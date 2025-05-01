import './bootstrap';
import 'cropperjs/dist/cropper.css';
import Cropper from 'cropperjs';
import bsCustomFileInput from 'bs-custom-file-input';

document.addEventListener('DOMContentLoaded', function() {
    // Initialize file input styling
    bsCustomFileInput.init();

    // Photo cropping functionality
    const image = document.getElementById('cropper-image');
    const fileInput = document.getElementById('baby_photo');
    const cropButton = document.getElementById('crop-button');
    const preview = document.getElementById('photo-preview');
    let cropper;

    fileInput.addEventListener('change', function(e) {
        const files = e.target.files;
        if (files && files.length > 0) {
            const file = files[0];

            if (!file.type.match('image.*')) {
                alert('Please select an image file');
                return;
            }

            const reader = new FileReader();
            reader.onload = function(event) {
                // Destroy previous cropper instance if exists
                if (cropper) {
                    cropper.destroy();
                }

                // Set image source and show modal
                image.src = event.target.result;
                $('#cropModal').modal('show');

                // Initialize cropper when modal is shown
                $('#cropModal').on('shown.bs.modal', function() {
                    cropper = new Cropper(image, {
                        aspectRatio: 1, // Square ratio
                        viewMode: 1,
                        autoCropArea: 0.8,
                        responsive: true,
                        movable: true,
                        zoomable: true,
                        rotatable: true,
                    });
                });
            };
            reader.readAsDataURL(file);
        }
    });

    cropButton.addEventListener('click', function() {
        if (cropper) {
            // Get cropped canvas
            const canvas = cropper.getCroppedCanvas({
                width: 500,
                height: 500,
                minWidth: 256,
                minHeight: 256,
                maxWidth: 2000,
                maxHeight: 2000,
                fillColor: '#fff',
                imageSmoothingEnabled: true,
                imageSmoothingQuality: 'high',
            });

            if (canvas) {
                // Convert to data URL and update preview
                const croppedImageUrl = canvas.toDataURL('image/jpeg');
                preview.innerHTML = `<img src="${croppedImageUrl}" class="img-thumbnail rounded-circle" width="150" height="150">`;
                document.getElementById('cropped_image_data').value = croppedImageUrl;

                // Hide modal
                $('#cropModal').modal('hide');
            }
        }
    });

    // Clean up when modal is hidden
    $('#cropModal').on('hidden.bs.modal', function() {
        if (cropper) {
            cropper.destroy();
        }
    });
});
