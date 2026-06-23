if(document.querySelector('#content')){tinymce.init({selector:'#content',height:500,plugins:'image link lists table code',toolbar:'undo redo | blocks | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist | link image | table | code',license_key:'gpl',images_upload_url:'/admin/upload-image',automatic_uploads:true,convert_urls:false})}

document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('input[type="file"]').forEach(function(input) {
        input.addEventListener('change', function() {
            if (this.files && this.files[0]) {
                const file = this.files[0];
                if (file.type.match('image.*')) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        let preview = input.parentElement.querySelector('img.preview, img');
                        if (!preview) {
                            preview = document.createElement('img');
                            preview.className = 'preview';
                            preview.style.maxWidth = '180px';
                            preview.style.borderRadius = '8px';
                            preview.style.marginTop = '10px';
                            preview.style.display = 'block';
                            input.parentElement.appendChild(preview);
                        }
                        preview.src = e.target.result;
                    };
                    reader.readAsDataURL(file);
                }
            }
        });
    });
});
