"use strict";

let initPopovers;
let initTooltips;
let initHoverTabs;
let checkFormValid;
let countrySelected;
let stateSelected;
let stateSelectedByName;
let checkboxRequiredCheck;
let initDatePicker;
let openModal;
let openOffcanvas;
let stepperFormNextPrev;

const AppInit = () => {

    //Elements
    const mainNavbar = document.querySelector("#main-navbar");
    const mainBody = document.querySelector("body");

    //background images
    const backgroundImages = document.querySelectorAll("[data-bg-image]");
    if ("IntersectionObserver" in window) {
        const observerBackground = new IntersectionObserver(entries => {
            entries.forEach(entry => {
    
                let image = entry.target.dataset.bgImage;
                if (entry.isIntersecting) {
                    if (image === "" || entry.target.classList.contains('bg-loaded')) return;
                    entry.target.style.backgroundImage = 'url(' + image + ')';
                    entry.target.style.opacity = 1;
                    entry.target.classList.add("bg-loaded");
                    return;
                }
    
            });
        }, {
            rootMargin: '0px 0px -75px 0px',
        });
    
        backgroundImages.forEach(bgEl => {
            //bgEl.style.opacity = 0;
            //bgEl.style.transition = "all .5s cubic-bezier(0.25, 0.1, 0.25, 1)";
            observerBackground.observe(bgEl);
        });
    } else {
        backgroundImages.forEach(bgEl => {
            let image = bgEl.dataset.bgImage;
            if (image === "" || bgEl.classList.contains('bg-loaded')) return;
            bgEl.style.backgroundImage = 'url(' + image + ')';
            bgEl.classList.add("bg-loaded");
            return;
        });
    }


    //bg-color
    (() => {
        'use strict'

        const backgroundColors = document.querySelectorAll('[data-bg-color]')
        Array.from(backgroundColors).forEach(bgElem => {
            let color = bg_elem.dataset.bgColor;
            if (color === "") return;
            bgElem.style.backgroundColor = '#' + color;
        });


    })();

    const backgroundParallaxes = document.querySelectorAll("[data-parallax-image]");
    if (backgroundParallaxes.length > 0) {
        new universalParallax().init();
    }

    openModal = (modalId) => {

        const modalForOpen = new bootstrap.Modal(document.getElementById(modalId));
        if(modalForOpen){
            modalForOpen.show();
        }
    }

    openOffcanvas = (modalId) => {

        const offcanvasForOpen = new bootstrap.Offcanvas(document.getElementById(modalId));
        if(offcanvasForOpen){
            offcanvasForOpen.show();
        }
    }

    initTooltips = () => {

        const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
        if (tooltipTriggerList.length > 0) {
            const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl));
        }
    }
    initTooltips();

    initPopovers = () => {

        const popoverTriggerList = document.querySelectorAll('[data-bs-toggle="popover"]')
        if (popoverTriggerList.length > 0) {
            const popoverList = [...popoverTriggerList].map(popoverTriggerEl => new bootstrap.Popover(popoverTriggerEl));
            toastList.forEach(toast => toast.show());
        }
    }
    initPopovers();

    const fancyBoxes = document.querySelectorAll('[data-fancybox]');
    if (fancyBoxes.length > 0) {
        Fancybox.bind("[data-fancybox]");
    }

    //Animations on scroll
    const animateElements = document.querySelectorAll('.animate__animated');
    const observer = new IntersectionObserver(entries => {
        entries.forEach(entry => {

            const animation = entry.target.dataset.animation;
            if (entry.isIntersecting) {
                entry.target.classList.remove('anim-opacity-0');
                entry.target.classList.add(animation);
                return;
            }
            //entry.target.classList.remove(animation);
            //entry.target.classList.add('animate__fadeOut');

        });
    }, {
        rootMargin: '0px 0px -75px 0px',
    });

    animateElements.forEach(animEl => {
        observer.observe(animEl);
    });


    //swiper
    (() => {
        'use strict'

        const swipera = document.querySelectorAll('.ea-swiper')
        Array.from(swipera).forEach(swiper => {

            let swiperOptions = JSON.parse(swiper.dataset.swiperOptions);

            const isSafari = /^((?!chrome|android).)*safari/i.test(navigator.userAgent);
            if( swiperOptions.slidesPerView == 'auto' && isSafari){
                swiperOptions.slidesPerView = 1.2;
                swiperOptions.breakpoints = {
                    768: {
                      slidesPerView: 2.5,
                    },
                    1200: {
                      slidesPerView: 3.5,
                    },
                  }
            }

            console.log(swiperOptions);

            let initSwiper = new Swiper(swiper, swiperOptions);

        });


    })();

    //form validation ajax load single
    checkFormValid = (form) => {
        form.addEventListener('submit', event => {

            var tcNoInput = form.querySelector('[name="tc_no"]');
            var nameInputs = form.querySelectorAll('.name-input');
            var isValid = true;

            if( tcNoInput && tcNoInput.hasAttribute('required')){
                // TC kimlik numarası validasyonu (11 haneli ve sayısal)
                if (!/^\d{11}$/.test(tcNoInput.value)) {
                    tcNoInput.setCustomValidity('11_hane_zorunlu');
                    isValid = false;
                } else {
                    tcNoInput.setCustomValidity(''); // Geçerli
                }
            }

            if( nameInputs.length > 0 ){
                nameInputs.forEach(nameInput => {
                    if( nameInput.hasAttribute('required')){
                        if (!/^\S+\s+\S+/.test(nameInput.value)) {
                            nameInput.setCustomValidity('En_az_2_kelime');
                            isValid = false;
                        } else {
                            nameInput.setCustomValidity(''); // Geçerli
                        }
                    }
                });
            }

            if (!form.checkValidity() || !isValid) {

                form.querySelector('[type=submit]').disabled = false;
                event.preventDefault();
                event.stopPropagation();
                isValid = true;

            } else {

                form.querySelector('[type=submit]').disabled = true;

                setTimeout(() => {
                    form.querySelector('[type=submit]').disabled = false;
                }, 10000);
                
            }

            form.classList.add('was-validated')
        }, false)
    }

    //form validation all on load
    (() => {
        'use strict'

        const forms = document.querySelectorAll('.needs-validation');

        Array.from(forms).forEach(form => {
            checkFormValid(form);
        });


    })();

    //checkbox required trick
    checkboxRequiredCheck = (elem) => {
        
        const checkGroup = elem.closest('.checkbox-group');
        const checkElems = checkGroup.querySelectorAll('.form-check-input');
        const checkedCheckElems = Array.from(checkElems).filter( x => x.checked === true );

        if( checkedCheckElems.length > 0 ){
            const removeRequired = [...checkElems].map(checkElem => checkElem.required = false);
        } else {
            const removeRequired = [...checkElems].map(checkElem => checkElem.required = true);
        }


    }

    //stepperForm isleri
    stepperFormNextPrev = (swiperId,nextOrPrev) => {

        const swiperEl = document.getElementById(swiperId);
        const formEl = swiperEl.closest('form');

        if( !formEl || !swiperEl || !nextOrPrev) return;

        if( nextOrPrev == 'prev' ){
            swiperEl.swiper.slidePrev();
            return;
        }

        if( nextOrPrev == 'next' ){

            //step icinde validasyon yapalim.
            const activeSlide = swiperEl.querySelector('.swiper-slide-active');
            const currentFields = activeSlide.querySelectorAll("input, select, textarea");
            let valid = true;

            currentFields.forEach((field) => {
                if (!field.checkValidity()) {
                    field.classList.add("is-invalid");
                    valid = false;
                } else {
                    field.classList.remove("is-invalid");
                }
            });

            if( valid ){
                swiperEl.swiper.slideNext();
            }
            
        }

    }


    //hover tabs
    initHoverTabs = () => {

        const hoverTabNavs = document.querySelectorAll('.hover-tab-navs a[data-bs-toggle="tab"]');

        if (hoverTabNavs.length > 0) {

            hoverTabNavs.forEach((triggerEl) => {
                const tabTrigger = new bootstrap.Tab(triggerEl);
        
                triggerEl.addEventListener('mouseover', (event) => {
                  event.preventDefault();
                  tabTrigger.show();
                });
        
                // Href link click handling
                triggerEl.addEventListener('click', (event) => {
                  if (triggerEl.href !== window.location.href) {
                    window.location.href = triggerEl.href;
                  }
                });
            });

        }
    }
    initHoverTabs();

    //States
    countrySelected = (guid) => {

        var options = '<option value="">Lütfen Seçiniz</option>';

        const countrySelect = document.getElementById('countries-' + guid);
        const stateSelect = document.getElementById('states-' + guid);
        const citySelect = document.getElementById('cities-' + guid);

        if (citySelect) {
            citySelect.innerHTML = options;
        }

        if (countrySelect) {

            fetch('/countries/states/' + countrySelect.value, {
                method: 'GET',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                },
            })
                .then(response => response.json())
                .then(json => {
                    json.states.forEach(state => {
                        options += '<option value="' + state.id + '">' + state.name + '</option>';
                    });
                })
                .then(() => {
                    stateSelect.innerHTML = options;
                })

        }

    }

    stateSelected = (guid) => {

        var options = '<option value="">Lütfen Seçiniz</option>';

        var stateSelect = document.getElementById('states-' + guid);
        var citySelect = document.getElementById('cities-' + guid);

        if (stateSelect && citySelect) {

            fetch('/states/cities/' + stateSelect.value, {
                method: 'GET',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                },
            })
                .then(response => response.json())
                .then(json => {
                    json.cities.forEach(city => {
                        options += '<option value="' + city.id + '">' + city.name + '</option>';
                    });
                })
                .then(() => {
                    citySelect.innerHTML = options;
                })

        }

    }

    stateSelectedByName = (guid) => {

        var options = '<option value="">Lütfen Seçiniz</option>';

        var stateSelect = document.getElementById('states-' + guid);
        var citySelect = document.getElementById('cities-' + guid);

        if (stateSelect && citySelect) {

            var stateId = stateSelect.options[stateSelect.selectedIndex].dataset.stateId;

            fetch('/states/cities/' + stateId, {
                method: 'GET',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                },
            })
                .then(response => response.json())
                .then(json => {
                    json.cities.forEach(city => {
                        options += '<option value="' + city.name + '">' + city.name + '</option>';
                    });
                })
                .then(() => {
                    citySelect.innerHTML = options;
                })

        }

    }

    //mixitup
    (() => {
        'use strict'

        const mixitupContainers = document.querySelectorAll('[data-filterable]')
        Array.from(mixitupContainers).forEach(elem => {
            var mixer = mixitup(elem);
        });

    })();

    //Scroll
    (() => {
        'use strict'

        const onScroll = (event) => {
            const scrollPosition = event.target.scrollingElement.scrollTop;
            mainBody.classList.toggle("sticky", scrollPosition > 50);
        };
        
        document.addEventListener("scroll", onScroll, { passive: true });
        document.addEventListener("touchstart", () => {}, { passive: true });

    })();

    //datepicker
    initDatePicker = (elem,) => {
        var picker = new Pikaday({ 
            field: elem,
            format: 'DD.MM.YYYY',
            firstDay:1,
            i18n: {
                previousMonth : 'Önceki Ay',
                nextMonth     : 'Sonraki Ay',
                months        : ['Ocak','Şubat','Mart','Nisan','Mayıs','Haziran','Temmuz','Ağustos','Eylül','Ekim','Kasım','Aralık'],
                weekdays      : ['Pazar','Pazartesi','Salı','Çarşamba','Perşembe','Cuma','Cumartesi'],
                weekdaysShort : ['Paz','Pzt','Sal','Çar','Per','Cum','Cts']
            },
            toString(date, format) {
                // you should do formatting based on the passed format,
                // but we will just return 'D/M/YYYY' for simplicity
                const day = date.getDate().toString().padStart(2, '0');
                const month = (date.getMonth() + 1).toString().padStart(2, '0');
                const year = date.getFullYear();
                return `${day}.${month}.${year}`;
            },
            parse(dateString, format) {
                // dateString is the result of `toString` method
                const parts = dateString.split('.');
                const day = parseInt(parts[0], 10);
                const month = parseInt(parts[1], 10) - 1;
                const year = parseInt(parts[2], 10);
                return new Date(year, month, day);
            }
        });
    }
    (() => {
        'use strict'

        const pickadayInputs = document.querySelectorAll('.pickaday');
        Array.from(pickadayInputs).forEach(input => {
            initDatePicker(input);
        });

    })();

    //typewrite
    const TxtType = function (el, toRotate, period) {
        this.toRotate = toRotate;
        this.el = el;
        this.loopNum = 0;
        this.period = parseInt(period, 10) || 2000;
        this.txt = '';
        this.tick();
        this.isDeleting = false;
    };

    TxtType.prototype.tick = function () {
        var i = this.loopNum % this.toRotate.length;
        var fullTxt = this.toRotate[i];

        if (this.isDeleting) {
            this.txt = fullTxt.substring(0, this.txt.length - 1);
        } else {
            this.txt = fullTxt.substring(0, this.txt.length + 1);
        }

        this.el.innerHTML = '<span class="wrap">' + this.txt + '</span>';

        var that = this;
        var delta = 100 - Math.random() * 100;

        if (this.isDeleting) { delta /= 2; }

        if (!this.isDeleting && this.txt === fullTxt) {
            delta = this.period;
            this.isDeleting = true;
        } else if (this.isDeleting && this.txt === '') {
            this.isDeleting = false;
            this.loopNum++;
            delta = 500;
        }

        setTimeout(function () {
            that.tick();
        }, delta);
    };

    window.onload = function () {
        var elements = document.getElementsByClassName('typewrite');
        for (var i = 0; i < elements.length; i++) {
            var toRotate = elements[i].getAttribute('data-type');
            var period = elements[i].getAttribute('data-period');
            if (toRotate) {
                new TxtType(elements[i], JSON.parse(toRotate), period);
            }
        }
    };

}

document.addEventListener('DOMContentLoaded', AppInit);