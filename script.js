function iniciarAutenticacao() {
  const clientId = "141467792185-sd98uk4h6gfibc3ipee7qrprj7968jcn.apps.googleusercontent.com";
  const redirectUri = "https://www.nickdwtyay.com.br/callback.html";
  const scope = "email profile";
  const authUrl = `https://accounts.google.com/o/oauth2/auth?client_id=${clientId}&redirect_uri=${redirectUri}&response_type=token&scope=${scope}`;

  window.location.href = authUrl;
}
