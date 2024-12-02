import axios from 'axios';
window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
import { toast } from 'vue3-toastify';
window.Toast = toast;
