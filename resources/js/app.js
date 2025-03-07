import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();
// pusher notifications
import Echo from 'laravel-echo'
import Pusher from 'pusher-js'
window.Echo = new Echo({
  broadcaster: 'pusher',
  key: '08413031fe149d183bae',
  cluster: 'eu',
  forceTLS: true
});

var channel = Echo.channel('my-channel');
channel.listen('.my-event', function(data) {
  alert(JSON.stringify(data));
});