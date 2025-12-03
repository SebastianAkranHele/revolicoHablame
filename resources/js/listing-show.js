// resources/js/listing-show.js

document.addEventListener('DOMContentLoaded', function() {
    console.log('listing-show.js carregado');

    // Elementos del DOM
    const mainImage = document.getElementById('mainImage');
    const thumbnails = document.querySelectorAll('.thumbnail');
    const copyPhoneBtn = document.querySelector('.copy-phone-btn');
    const copyLinkBtn = document.querySelector('.copy-link-btn');
    const phoneNumber = document.querySelector('.phone-number');

    // Cambiar imagen principal al hacer clic en miniatura
    if (thumbnails.length > 0) {
        thumbnails.forEach(thumbnail => {
            thumbnail.addEventListener('click', function() {
                const imageSrc = this.getAttribute('data-image-src');

                if (mainImage && imageSrc) {
                    // Actualizar imagen principal
                    mainImage.src = imageSrc;

                    // Remover clase active de todas las miniaturas
                    thumbnails.forEach(thumb => {
                        thumb.classList.remove('active');
                        thumb.style.borderColor = 'transparent';
                    });

                    // Agregar clase active a la miniatura clickeada
                    this.classList.add('active');
                    this.style.borderColor = '#007bff';

                    console.log('Imagen cambiada a:', imageSrc);
                }
            });

            // Efecto hover en miniaturas
            thumbnail.addEventListener('mouseenter', function() {
                this.style.opacity = '0.8';
            });

            thumbnail.addEventListener('mouseleave', function() {
                if (!this.classList.contains('active')) {
                    this.style.opacity = '1';
                }
            });
        });

        // Activar primera miniatura por defecto
        if (thumbnails.length > 0) {
            thumbnails[0].classList.add('active');
            thumbnails[0].style.borderColor = '#007bff';
        }
    }

    // Copiar número de teléfono
    if (copyPhoneBtn && phoneNumber) {
        copyPhoneBtn.addEventListener('click', function() {
            const phone = phoneNumber.textContent.trim();

            if (navigator.clipboard && window.isSecureContext) {
                // Usar Clipboard API (moderno)
                navigator.clipboard.writeText(phone)
                    .then(() => {
                        showNotification('Número copiado: ' + phone);
                        console.log('Número copiado:', phone);
                    })
                    .catch(err => {
                        console.error('Error al copiar:', err);
                        fallbackCopyToClipboard(phone);
                    });
            } else {
                // Fallback para navegadores antiguos
                fallbackCopyToClipboard(phone);
            }
        });
    }

    // Copiar enlace
    if (copyLinkBtn) {
        copyLinkBtn.addEventListener('click', function() {
            const url = window.location.href;

            if (navigator.clipboard && window.isSecureContext) {
                navigator.clipboard.writeText(url)
                    .then(() => {
                        showNotification('Link copiado!');
                        console.log('Link copiado:', url);
                    })
                    .catch(err => {
                        console.error('Error al copiar:', err);
                        fallbackCopyToClipboard(url);
                    });
            } else {
                fallbackCopyToClipboard(url);
            }
        });
    }

    // Función de fallback para copiar
    function fallbackCopyToClipboard(text) {
        const textArea = document.createElement('textarea');
        textArea.value = text;

        // Hacerlo invisible
        textArea.style.position = 'fixed';
        textArea.style.top = '0';
        textArea.style.left = '0';
        textArea.style.width = '2em';
        textArea.style.height = '2em';
        textArea.style.padding = '0';
        textArea.style.border = 'none';
        textArea.style.outline = 'none';
        textArea.style.boxShadow = 'none';
        textArea.style.background = 'transparent';

        document.body.appendChild(textArea);
        textArea.focus();
        textArea.select();

        try {
            const successful = document.execCommand('copy');
            const msg = successful ? 'Texto copiado!' : 'No se pudo copiar';
            showNotification(msg);
            console.log(msg);
        } catch (err) {
            console.error('Fallback error al copiar:', err);
            showNotification('Error al copiar');
        }

        document.body.removeChild(textArea);
    }

    // Mostrar notificación
    function showNotification(message) {
        // Crear elemento de notificación
        const notification = document.createElement('div');
        notification.className = 'alert alert-success alert-dismissible fade show';
        notification.style.cssText = `
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 9999;
            min-width: 250px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        `;
        notification.innerHTML = `
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        `;

        // Agregar al DOM
        document.body.appendChild(notification);

        // Auto-remover después de 3 segundos
        setTimeout(() => {
            notification.remove();
        }, 3000);
    }

    // Efectos hover en tarjetas
    const listingCards = document.querySelectorAll('.listing-card');
    listingCards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.boxShadow = '0 .5rem 1rem rgba(0,0,0,.15)';
        });

        card.addEventListener('mouseleave', function() {
            this.style.boxShadow = 'none';
        });
    });

    // Efectos en botones de compartir
    const shareButtons = document.querySelectorAll('.share-buttons .btn');
    shareButtons.forEach(button => {
        button.addEventListener('mouseenter', function() {
            this.style.transform = 'scale(1.1)';
        });

        button.addEventListener('mouseleave', function() {
            this.style.transform = 'scale(1)';
        });
    });

    // Inicializar tooltips de Bootstrap si están disponibles
    if (typeof bootstrap !== 'undefined') {
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        const tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });

        // Agregar tooltips a los botones
        if (copyPhoneBtn) {
            copyPhoneBtn.setAttribute('data-bs-toggle', 'tooltip');
            copyPhoneBtn.setAttribute('data-bs-placement', 'top');
            copyPhoneBtn.setAttribute('title', 'Copiar número de teléfono');
            new bootstrap.Tooltip(copyPhoneBtn);
        }

        if (copyLinkBtn) {
            copyLinkBtn.setAttribute('data-bs-toggle', 'tooltip');
            copyLinkBtn.setAttribute('data-bs-placement', 'top');
            copyLinkBtn.setAttribute('title', 'Copiar enlace del anuncio');
            new bootstrap.Tooltip(copyLinkBtn);
        }
    }

    // Configurar evento de denuncia
    const reportLink = document.querySelector('.report-section a');
    if (reportLink) {
        reportLink.addEventListener('click', function(e) {
            e.preventDefault();

            // Aquí iría la lógica de denuncia
            if (confirm('¿Desea denunciar este anuncio?')) {
                showNotification('Denuncia enviada. Gracias por su colaboración.');
                console.log('Anuncio denunciado');
                // Aquí podrías hacer una petición AJAX
            }
        });
    }

    console.log('Script de detalle de anuncio inicializado correctamente');
});
