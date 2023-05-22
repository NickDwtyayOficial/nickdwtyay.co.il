// Espera que a página seja carregada completamente
document.addEventListener('DOMContentLoaded', function() {
  // Obtém a referência para o elemento de estatísticas
  var statisticsElement = document.getElementById('statistics');

  // Atualiza as estatísticas (pode ser feito por AJAX ou WebSocket, conforme mencionado anteriormente)
  var totalUsers = 1000;
  var activeUsers = 500;
  document.getElementById('total-users').textContent = totalUsers;
  document.getElementById('active-users').textContent = activeUsers;

  // Exibe o elemento de estatísticas
  statisticsElement.style.display = 'block';
});
