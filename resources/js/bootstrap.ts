import axios from 'axios';
import gsap from 'gsap';
import { ScrollTrigger } from 'gsap/all';
window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
gsap.registerPlugin(ScrollTrigger);
window.gsap = gsap;
