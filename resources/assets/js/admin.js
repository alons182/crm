(function($){

    console.log('msg');
    

    $("form[data-confirm]").submit(function() {
        if ( ! confirm($(this).attr("data-confirm"))) {
            return false;
        }
    });

     $("select[name='referred']").change(function() {

      
            if ($(this).val() === 'others') {
                $("input[name='referred_others']").attr('disabled', false).focus();
                

            } else {
                  $("input[name='referred_others']").attr('disabled', true);
                  $("input[name='referred_others']").val('');
            }
        });
   

    var chkItem = $('.chk-item');
    var chkSelectAll = $('#select-all');
    var btnDeleteMultiple = $('.delete-multiple');

   
    $('.btn-multiple').on('click',function(e) {

        var action = $(this).data('action');

        chkSelectAll.val(action);
        $('#select-action').val(action);
        (verificaChkActivo(chkItem)) ? $('#form-option-chk').submit() : alert('Seleccione un registro de la lista');


        e.preventDefault();

    });

    function verificaChkActivo(chks) {
        var state = false;

        chks.each(function(){

            if(this.checked)
            {

                state = true;


            }

        });

        return state;
    }
     var status = $('#status'),
        province = $('#province'),
        referred = $('#referred'),
        sellers = $('#seller'),
        filters = $(".filtros");
        
    function submitForm(){
        filters.find('form').submit();
    }

    status.change(submitForm);
    province.change(submitForm);
    referred.change(submitForm);
    sellers.change(submitForm);
    

    $('.btn-edit-slug').on('click',function(){
        $('input[name="slug"]').prop( "readOnly", null );
    });



    // add modal user

    $('.users').on('click', '.delete', function(e) {
        $(this).parent('li').remove();
        $('input[name="user_id"]').val('');
    });

    

    $('#btn-add-user').on('click', function(event) {
        event.preventDefault();
      
        getUsers(fillUsersInfo);

    });
    
    $('#modalAddClient').find('.btn-primary').on('click', function(event) {
        event.preventDefault();

        //var allVals = [];
        $('[name=chkUsers]:checked').each(function() {
            // allVals.push($(this).val());
            $('ul.users').empty();
            for (var i = 0 ; i < users.length; i++) {

                if($(this).val() == users[i].id)
                {



                        if (yaAgregado($(this).val()) == false)
                        {
                    $('ul.users').append('<li data-id="' + users[i].id +'"><span class="delete" data-id="'+ users[i].id +'"><i class="glyphicon glyphicon-remove"></i></span>'+
                    '<span class="label label-success">'+ users[i].name +'</span><input type="hidden" name="sellers[]" value="'+users[i].id +'"/> </li>');

                    $('input[name="user_id"]').val(users[i].id);
                    /* $('ul.users').append('<li data-id="' + users[i].id +'"><span class="delete" data-id="'+ users[i].id +'"><i class="glyphicon glyphicon-remove"></i></span>'+
                     '<span class="label label-success">'+ users[i].name +'</span>'+
                     '<input type="hidden" name="patner_id" value="'+ users[i].id +'"></li>');*/
                        }



                }
            };


        });

        $('#modalAddClient').modal('hide');


    });
    $('#modalAddUser').find('.btn-primary').on('click', function(event) {
        event.preventDefault();

        //var allVals = [];
        $('[name=chkUsers]:checked').each(function() {
            // allVals.push($(this).val());
            //$('ul.users').empty();
            for (var i = 0 ; i < users.length; i++) {

                if($(this).val() == users[i].id)
                {



                        if (yaAgregado($(this).val()) == false)
                        {
                    $('ul.users').append('<li data-id="' + users[i].id +'"><span class="delete" data-id="'+ users[i].id +'"><i class="glyphicon glyphicon-remove"></i></span>'+
                    '<span class="label label-success">'+ users[i].name +'</span><input type="hidden" name="clients[]" value="'+users[i].id +'"/> </li>');

                    $('input[name="user_id"]').val(users[i].id);
                    /* $('ul.users').append('<li data-id="' + users[i].id +'"><span class="delete" data-id="'+ users[i].id +'"><i class="glyphicon glyphicon-remove"></i></span>'+
                     '<span class="label label-success">'+ users[i].name +'</span>'+
                     '<input type="hidden" name="patner_id" value="'+ users[i].id +'"></li>');*/
                        }



                }
            };


        });

        $('#modalAddUser').modal('hide');


    });

    $('.modal-dialog').find('.pagination').on('click','a', function(event) {
        event.preventDefault();
        getUsers(fillUsersInfo,$(this).data('page'));
    });


    function yaAgregado(id){

        var res = false;

        $('.users').children('li').each(function() {

            if($(this).data('id') == parseInt(id))
                res = true;

        });

        return res;

    }
    function Pagination (total, page, max_pages,items_per_page) {


        var len = total,// total de items
            page = page,// pagina actual
            pagesVisibles = max_pages,
            totalPages = Math.ceil(len / items_per_page),
            pageStart = (page % pagesVisibles === 0) ? (parseInt(page / pagesVisibles, 10) - 1) * pagesVisibles + 1 : parseInt(page / pagesVisibles, 10) * pagesVisibles + 1,//calculates the start page.
            output = [],
            i = 0,
            counter = 0;


        pageStart = pageStart < 1 ? 1 : pageStart;//check the range of the page start to see if its less than 1.

        for (i = pageStart, counter = 0; counter < pagesVisibles && i <= totalPages; i = i + 1, counter = counter + 1) {//fill the pages

            output.push(i);
        }

        output.first = 1;//add the first when the current page leaves the 1st page.

        if (page > 1) {// add the previous when the current page leaves the 1st page
            output.prev = page - 1;
        } else {
            output.prev = 1;
        }

        if (page < totalPages) {// add the next page when the current page doesn't reach the last page
            output.next = page + 1;
        } else {
            output.next = totalPages;
        }

        output.last = totalPages;// add the last page when the current page doesn't reach the last page

        output.current = page;//mark the current page.

        output.total = totalPages;

        output.numberOfPages = pagesVisibles;


        if(output.length>0)
        {

            buildItem(output);
        }




    }
    function buildItem (output){
        $('.pagination').html("");
        if (output.first) {//if the there is first page element


            var first = $('<li></li>',{
                class: 'first',
                html : "<a href='#"+ output.first +"' data-page='"+  output.first +"'> &lt;&lt;</a>"

            });


            if (first) {
                $('.pagination').append(first);

            }

        }

        if (output.prev) {//if the there is previous page element

            var prev = $('<li></li>',{
                class: 'prev',
                html : "<a href='#"+ output.prev +"' data-page='"+  output.prev +"'> &lt;</a>"

            });

            if (prev) {
                $('.pagination').append(prev);

            }

        }


        for (var i = 0; i < output.length; i = i + 1) {//fill the numeric pages.

            var p = $('<li></li>',{
                class: (output[i] === output.current) ?  "active" : "",
                html : "<a href='#"+ output[i] +"' data-page='"+ output[i] +"'>"+ output[i] +"</a>"

            });


            if (p) {
                $('.pagination').append(p);
            }
        }

        if (output.next) {//if there is next page

            var next = $('<li></li>',{
                class: 'next',
                html : "<a href='#"+ output.next +"' data-page='"+  output.next +"' > &gt;</a>"

            });

            if (next) {
                $('.pagination').append(next);
            }
        }

        if (output.last) {//if there is last page

            var last = $('<li></li>',{
                class: 'last',
                html : "<a href='#"+ output.last +"' data-page='"+ output.last +"'> &gt;&gt;</a>"

            });

            if (last) {
                $('.pagination').append(last);
            }
        }
    }

    function getUsers (callback, page) {
        var p = page ? parseInt(page, 10) : 1;
        $('.loading-search').removeClass('hidden');
        $.ajax({

            url :  $('.modal').data('url'),
            dataType : 'json',
            data : { exc_id: $('input[name="exc_id"]').val() , page: p }

        }).done(callback);
    }
    

    function UserTemplate(users)
    {

        var templateHtml = $.trim( $('#usersTemplate').html() );

        var template = Handlebars.compile( templateHtml );

        return template(users);

    }


    function fillUsersInfo(jsonData) {
        if (jsonData.error) {
            return onError();
        }
        $('.loading-search').addClass('hidden');
        users = $.map(jsonData.data ,function(obj, index){
            return {
                id : obj.id,
                name : (obj.name) ? obj.name : obj.fullname,
                assigned: (obj.sellers) ? obj.sellers.length : 0

            }

        });
        
        var html = UserTemplate(users);

        $('.modal').find('.tbody').html( html );

        Pagination(jsonData.total, jsonData.current_page, 10,jsonData.per_page);

    }
    

    $('#searchText').on('keypress', function(event) {

        if (event.keyCode == 13) {
            event.preventDefault();
        }

    });
    $('#searchText').on('keyup', function(event) {
        search();
    });
    function search() {

        var input = $('#searchText'),
            key =input.val(),
            self = this;

        if(key.length >=3 ){

            $('.loading-search').removeClass('hidden');
            clearTimeout( this.timer );
            this.timer = setTimeout(function () {
                console.log('search ' + key);
                getUsersByName(fillUsersInfo,key);

            },200);


        }else if(key.length == 0){
            $('.dropdown').removeClass('open');
            getUsers(fillUsersInfo);
        }




    }
    function getUsersByName (callback, key) {

        $.ajax({

            url :  $('.modal').data('url'),
            dataType : 'json',
            data : { exc_id: $('input[name=exc_id]').val(), key: key }

        }).done(callback);
    }



})(jQuery);