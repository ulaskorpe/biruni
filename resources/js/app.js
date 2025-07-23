import './bootstrap';
import { createApp, h } from 'vue';
import { createInertiaApp, Head, Link } from '@inertiajs/vue3';
import { ZiggyVue } from '../../vendor/tightenco/ziggy/dist/vue.m';
import PrimeVue from 'primevue/config';
import ConfirmationService from 'primevue/confirmationservice';
//import DialogService from 'primevue/dialogservice';
import ToastService from 'primevue/toastservice';
import Tooltip from 'primevue/tooltip';
import FormErrors from './Components/FormErrors';
import AppLayout from './Layouts/AppLayout';

createInertiaApp({
    resolve: async name => {
        const page = (await import(`./Pages/${name}`)).default;
        page.layout = page.layout || AppLayout;
        return page;
    },
    setup({ el, App, props, plugin }) {
        return createApp({ render: () => h(App, props) })
            .use(plugin)
            .component('Head',Head)
            .component('Link',Link)
            .component('FormErrors',FormErrors)
            .use(ZiggyVue, Ziggy)
            .use(PrimeVue,{
                locale:{
                    choose: 'Seç',
                    upload: '',
                    cancel: '',
                    dayNames: ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"],
                    dayNamesShort: ["Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat"],
                    dayNamesMin: ["Su","Mo","Tu","We","Th","Fr","Sa"],
                    monthNames: ["January","February","March","April","May","June","July","August","September","October","November","December"],
                    monthNamesShort: ["Jan", "Feb", "Mar", "Apr", "May", "Jun","Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
                    today: 'Today',
                    weekHeader: 'Wk',
                    firstDayOfWeek: 0,
                    dateFormat:'dd-mm-yy',
                    clear: 'Clear'
                },
                pt: {
                    fileupload: {
                        buttonbar:{
                            class:'bg-transparent border-0 px-0 pt-0 pb-3'
                        },
                        uploadButton:{
                            root:'bg-success border-success'
                        },
                        cancelButton:{
                            root:'bg-danger border-danger'
                        }
                    },
                } 
            })
            .use(ConfirmationService)
            .use(ToastService)
            .directive('tooltip', Tooltip)
            .mount(el);
    },
    progress: {
        delay: 0,
        color: '#3E97FF',
        includeCSS: true,
        showSpinner: false,
      },
});