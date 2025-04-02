import './bootstrap';
import Toastify from 'toastify-js';
import Alpine from 'alpinejs';
import { library, dom } from '@fortawesome/fontawesome-svg-core';
import { faEye, faEdit, faTrash, faCheck, faEllipsis, faUser, faRightFromBracket, faRightToBracket, faUserPlus, faArrowLeft, faUsers, faCalendarAlt, faHeart } from '@fortawesome/free-solid-svg-icons';
import { faU } from '@fortawesome/free-solid-svg-icons';

library.add(faEye, faEdit, faTrash, faCheck,faEllipsis, faUser, faRightFromBracket, faRightToBracket, faUserPlus, faArrowLeft, faU, faUsers, faCalendarAlt,faHeart);
dom.watch();

window.Alpine = Alpine;

Alpine.start();

window.Toastify = Toastify;
