import axios from 'axios';

require("jquery");

require("jquery-mask-plugin")

window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
