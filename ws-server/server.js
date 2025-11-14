import { WebSocketServer } from 'ws';
import express from 'express';
import bodyParser from 'body-parser';
import cors from 'cors';

const wss = new WebSocketServer({ port: 6001 });
const app = express();
app.use(cors());
app.use(bodyParser.json());

// 📡 WebSocket σύνδεση
wss.on('connection', (ws) => {
  console.log('🟢 Client connected');

  ws.on('message', (message) => {
    console.log('📩 Received:', message);
  });

  ws.on('close', () => console.log('🔴 Client disconnected'));
});

// 📤 HTTP endpoint για Laravel
app.post('/broadcast', (req, res) => {
  const { message } = req.body;
  console.log('📨 Broadcast from Laravel:', message);

  // Στέλνουμε σε όλους τους clients
  wss.clients.forEach(client => {
    if (client.readyState === client.OPEN) {
      client.send(JSON.stringify({ message }));
    }
  });

  res.json({ status: 'sent' });
});

// Ξεκινά ο HTTP server (π.χ. στη θύρα 3001)
app.listen(3001, () => {
  console.log('🚀 HTTP API server running on port 3001');
});
