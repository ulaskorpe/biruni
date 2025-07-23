"use strict";

let openOffcanvasContent;

const ThemeInit = () => {

    const dynamicOffCanvasDiv = document.getElementById('dynamic-offcanvas');
    const dynamicOffCanvas = new bootstrap.Offcanvas('#dynamic-offcanvas');
    const dynamicOffCanvasTitle = document.getElementById('dynamic-offcanvas-title');
    const dynamicOffCanvasBody = document.getElementById('dynamic-offcanvas-body');

    if (dynamicOffCanvasDiv) {
        dynamicOffCanvasDiv.addEventListener('hidden.bs.offcanvas', event => {
            dynamicOffCanvasTitle.innerText = '';
            dynamicOffCanvasBody.innerHTML = '<div class="ps-4"><div class="spinner-border spinner-border-lg" role="status"><span class="visually-hidden">Loading...</span></div></div>';
        });
    }

    openOffcanvasContent = (uuid,language,title) => {

        if( !uuid || !language || !title ){
            return;
        }

        dynamicOffCanvasTitle.innerText = title;
        dynamicOffCanvas.show();

        fetch(`/fetch/offcanvas-content/${uuid}/${language}`).then(function (response) {
            return response.json();
        }).then((json) => {

            setTimeout(() => {
                dynamicOffCanvasBody.innerHTML = json.html;
            },1000);

        }).catch((error) => {
            
            dynamicOffCanvas.hide();

            console.error(error)

        })
    }

}

document.addEventListener('DOMContentLoaded', ThemeInit);