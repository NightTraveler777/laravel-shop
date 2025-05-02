$(document).ready(function() {
    class MyUploadAdapter {
        constructor( loader ) {
            this.loader = loader;
        }

        upload() {
            return this.loader.file
                .then( file => new Promise( ( resolve, reject ) => {
                    this._initRequest();
                    this._initListeners( resolve, reject, file );
                    this._sendRequest( file );
                } ) );
        }

        abort() {
            if ( this.xhr ) {
                this.xhr.abort();
            }
        }

        _initRequest() {
            const xhr = this.xhr = new XMLHttpRequest();

            xhr.open( 'POST', `${route}`, true );
            xhr.responseType = 'json';
        }

        _initListeners( resolve, reject, file ) {
            const xhr = this.xhr;
            const loader = this.loader;
            const genericErrorText = `Couldn't upload file: ${ file.name }.`;

            xhr.addEventListener( 'error', () => reject( genericErrorText ) );
            xhr.addEventListener( 'abort', () => reject() );
            xhr.addEventListener( 'load', () => {
                const response = xhr.response;

                if ( !response || response.error ) {
                    return reject( response && response.error ? response.error.message : genericErrorText );
                }

                resolve( response );
            } );

            if ( xhr.upload ) {
                xhr.upload.addEventListener( 'progress', evt => {
                    if ( evt.lengthComputable ) {
                        loader.uploadTotal = evt.total;
                        loader.uploaded = evt.loaded;
                    }
                } );
            }
        }

        _sendRequest( file ) {
            const data = new FormData();

            data.append( 'upload', file );

            this.xhr.send( data );
        }
    }

    function MyCustomUploadAdapterPlugin( editor ) {
        editor.plugins.get( 'FileRepository' ).createUploadAdapter = ( loader ) => {
            return new MyUploadAdapter( loader );
        };
    }

    ClassicEditor
        .create( document.querySelector( '#description' ), {
            toolbar: ['heading', '|', 'bold', 'italic', 'alignment', '|', 'undo', 'redo']
        } )
        .catch( error => {
            console.error( error );
        } );

    ClassicEditor
        .create( document.querySelector( '.description' ), {
            toolbar: ['heading', '|', 'bold', 'italic', 'alignment', '|', 'undo', 'redo']
        } )
        .catch( error => {
            console.error( error );
        } );

    ClassicEditor
        .create( document.querySelector( '#content' ), {
            extraPlugins: [ MyCustomUploadAdapterPlugin ],
        } )
        .catch( error => {
            console.error( error );
        } );

    bsCustomFileInput.init();

    $('.select2').select2({
        // tags: true
    });

    $('#form-create').on('click', '.add-btn', function(event){
        event.preventDefault();
        $(this).removeClass('add-btn').addClass('remove-btn');
        $(this).find('i').removeClass('fa-plus').addClass('fa-minus');

        let mainFormat = $(this).data('main-format');
        let format = $(this).data('format');

        let priceLabel = $('<label>Цена</label>')
            .attr('for', format + '_price');

        let priceInput = $('<input>')
            .addClass('form-control')
            .attr('id', format + '_price')
            .attr('type', 'text')
            .attr('name', 'format[' + mainFormat + '][format][' + format + '][price]')
            /*.prop('required', true)*/;

        let descriptionLabel = $('<label>Описание</label>')
            .attr('for', format + '_description');

        let descriptionTextarea = $('<textarea></textarea>')
            .addClass('form-control')
            .attr('id', format + '_description')
            .attr('name', 'format[' + mainFormat + '][format][' + format + '][description]')
            .attr('rows', '7')
            .attr('placeholder', 'Описание...')
            /*.prop('required', true)*/;

        $(this).closest('label')
            .after(descriptionTextarea)
            .after(descriptionLabel)
            .after(priceInput)
            .after(priceLabel);

        ClassicEditor
            .create( document.querySelector( `#${format}_description` ), {
                toolbar: ['heading', '|', 'bold', 'italic', 'alignment', '|', 'undo', 'redo']
            } )
            .catch( error => {
                console.error( error );
            } );
    });

    $('#form-create').on('click', '.remove-btn', function(event){
        event.preventDefault();
        $(this).removeClass('remove-btn').addClass('add-btn');
        $(this).find('i').removeClass('fa-minus').addClass('fa-plus');

        let mainFormat = $(this).data('main-format');
        let format = $(this).data('format');

        $(`#form-create label[for="${format}_price"]`).remove();
        $(`#form-create input#${format}_price`).remove();
        $(`#form-create label[for="${format}_description"]`).remove();
        $(`#form-create textarea#${format}_description + .ck`).remove();
        $(`#form-create textarea#${format}_description`).remove();
    });

    $('#form-create').on('submit',function(event){
        event.preventDefault();

        let data = new FormData();

        data.append( '_token', $('input[name="_token"]').attr('value') );
        data.append( 'genre_id', $('#genre_id option:selected').val() );
        data.append( 'name', $('#name').val() );

        let label_id = $('#label_id option:selected').val();
        if (label_id) {
            data.append( 'label_id', label_id );
        }

        /*let artists = [];
        $('#artists option').each(function(i) {
            if (this.selected == true) {
                artists.push(this.value);
            }
        });
        data.append( 'artists[]', artists );*/

        let artists = $('#artists').val();
        // let artists = $('#artists option:selected').val();
        if (artists) {
            data.append( 'artists[]', artists );
        }

        let tags = $('#tags').val();
        if (tags) {
            data.append( 'tags[]', tags );
        }

        /*let data = {
            "_token": $('input[name="_token"]').attr('value'),
            genre_id: $('#genre_id option:selected').val(),
            name: $('#name').val(),
        };*/

        let description = $('#description').val();
        if (description) {
            data.append( 'description', description );
        }

        let tracklist = $('#tracklist').val();
        if (tracklist) {
            data.append( 'tracklist', tracklist );
        }

        let file_data = $("#cover").prop('files')[0];
        data.append('cover', file_data);

        /*if ($("#cover").val()) {
            let files = document.getElementById('cover').files;
            $.each($("#cover")[0].files, function(key, input) {
                data.append('file[]', input);
            });
        }*/

        let cd_price = $('#cd_price').val();
        if (cd_price) {
            data.append( 'format[discs][format][cd][name]', 'CD' );
        }
        data.append( $('#cd_price').attr('name'), cd_price );

        let cd_description = $('#cd_description + .ck .ck-content').html();
        if (cd_description) {
            data.append( $('#cd_description').attr('name'), cd_description );
        }

        let dvd_price = $('#dvd_price').val();
        if (dvd_price) {
            data.append( 'format[discs][format][dvd][name]', 'DVD' );
        }
        data.append( $('#dvd_price').attr('name'), dvd_price );

        let dvd_description = $('#dvd_description + .ck .ck-content').html();
        if (dvd_description) {
            data.append( $('#dvd_description').attr('name'), dvd_description );
        }

        if (cd_price || dvd_price) {
            data.append( 'format[discs][name]', 'Диски' );
        }

        let black_vinyl_price = $('#black-vinyl_price').val();
        if (black_vinyl_price) {
            data.append( 'format[vinyl][format][black-vinyl][name]', 'Черный' );
        }
        data.append( $('#black-vinyl_price').attr('name'), black_vinyl_price );

        let black_vinyl_description = $('#black-vinyl_description + .ck .ck-content').html();
        if (black_vinyl_description) {
            data.append( $('#black-vinyl_description').attr('name'), black_vinyl_description );
        }

        let color_vinyl_price = $('#color-vinyl_price').val();
        if (color_vinyl_price) {
            data.append( 'format[vinyl][format][color-vinyl][name]', 'Цветной' );
        }
        data.append( $('#color-vinyl_price').attr('name'), color_vinyl_price );

        let color_vinyl_description = $('#color-vinyl_description + .ck .ck-content').html();
        if (color_vinyl_description) {
            data.append( $('#color-vinyl_description').attr('name'), color_vinyl_description );
        }

        if (black_vinyl_price || color_vinyl_price) {
            data.append( 'format[vinyl][name]', 'Винил' );
        }

        /*$.each( data, function( key, value ){
            formData.append( key, value );
        });*/

        console.log(data);

        let url;
        let album_id = $(this).data('album-id');
        if (album_id) {
            url = '/admin/albums/ajax_update';
            data.append( 'album_id', album_id );
        } else {
            url = '/admin/albums/ajax_store';
        }

        $.ajax({
            url: url,
            // url: "/user/ajax",
            type: "POST",
            cache: false,
            contentType: false,
            processData: false,
            enctype: 'multipart/form-data',
            dataType: 'json',
            data: data,
            xhr: function() {
                var xhr = $.ajaxSettings.xhr(); // получаем объект XMLHttpRequest
                if ($("#cover").val()) {
                    xhr.upload.addEventListener('progress', function(evt) { // добавляем обработчик события progress (onprogress)
                        if (evt.lengthComputable) { // если известно количество байт
                            // высчитываем процент загруженного
                            var percentComplete = Math.ceil(evt.loaded / evt.total * 100);
                            // устанавливаем значение в атрибут value тега <progress>
                            // и это же значение альтернативным текстом для браузеров, не поддерживающих <progress>
                            $('#progressbar').val(percentComplete).text('Загружено ' + percentComplete + '%');
                        }
                    }, false);
                }
                return xhr;
            },
            success: function(response) {
                console.log(response.request);
                if (response.hasOwnProperty('error')) {
                    let div = $('<div>')
                        .addClass('alert alert-danger');
                    let ul = $('<ul>')
                        .addClass('list-unstyled');

                    $.each(response.error, function(index, value) {
                        $.each(value, function(key, val) {
                            ul.append('<li>' + val + '</li>');
                        });
                    });

                    div.append(ul);

                    $('.alert-wrap .col-12')
                        .empty()
                        .append(div);
                }

                if (response.hasOwnProperty('success')) {
                    console.log(response.img);
                    let div = $('<div>')
                        .addClass('alert alert-success');
                    let ul = $('<ul>')
                        .addClass('list-unstyled');

                    ul.append('<li>' + response.success + '</li>');
                    div.append(ul);

                    $('.alert-wrap .col-12')
                        .empty()
                        .append(div);

                    $('#form-create .img-thumbnail').attr('src', 'http://' + document.domain + '/storage/' + response.img);
                }
            },
        });
    });
});
