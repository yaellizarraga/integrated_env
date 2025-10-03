const express = require('express');
const bodyParser = require('body-parser');
const xml2js = require('xml2js');
const axios = require('axios');
const fs = require('fs');
const path = require('path')
const app = express();

const ACCESS_TOKEN = 'mi-token-super-secreto-123';

app.use(bodyParser.text({ type: 'text/xml' }));

app.get('/wsdl', (req, res) => {
  const wsdlPath = path.join(__dirname, 'venta.wsdl');
  const wsdlContent = fs.readFileSync(wsdlPath, 'utf8');
  res.type('text/xml');
  res.send(wsdlContent);
});

// Middleware para validar el token
async function verificarToken(req, res, next) {
  const authHeader = req.headers['authorization'];
  if (!authHeader) {
    await axios.post('http://system-b/api/dump_log.php', { log: true, action: 'tokenRequerido', token: '' }, {
      headers: { 'Content-Type': 'application/json' }
    });
    return res.status(401).send('Token requerido');
  }
  if (authHeader != ACCESS_TOKEN) {
    await axios.post('http://system-b/api/dump_log.php', { log: true, action: 'tokenInvalido', token: authHeader }, {
      headers: { 'Content-Type': 'application/json' }
    });
    return res.status(403).send('Token inválido');
  }
  next();
}

app.post('/soap', verificarToken, async (req, res) => {
  xml2js.parseString(req.body, async (err, result) => {
    if (err) return res.status(400).send('XML inválido');

    const datosVenta = result['SOAP-ENV:Envelope']['SOAP-ENV:Body'][0]['ns1:registrarVenta'][0];
    const jsonVenta = {
      cliente: datosVenta.cliente[0],
      producto: datosVenta.producto[0],
      cantidad: parseInt(datosVenta.cantidad[0]),
      precio: parseFloat(datosVenta.precio[0]),
      metodo: datosVenta.metodo[0]
    };

    await axios.post('http://system-b/api/', jsonVenta, {
      headers: { 'Content-Type': 'application/json' }
    });

    await axios.post('http://system-b/api/dump_log.php', { log: true, action: 'registrarVenta' }, {
      headers: { 'Content-Type': 'application/json' }
    });

    // Respuesta SOAP de éxito
    const respuestaSOAP = `
      <soap:Envelope xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">
        <soap:Body>
          <registrarVentaResponse>
            <resultado>OK</resultado>
          </registrarVentaResponse>
        </soap:Body>
      </soap:Envelope>
    `;
    res.type('text/xml');
    res.send(respuestaSOAP);
  });
});

app.listen(3000, () => {
  console.log('Servidor SOAP escuchando en el puerto 3000');
});

