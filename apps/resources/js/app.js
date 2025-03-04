import './bootstrap';
import 'flowbite';

import './scanner';

import { disableSubmitIfNoChanges } from './validate';
window.disableSubmitIfNoChanges = disableSubmitIfNoChanges;
