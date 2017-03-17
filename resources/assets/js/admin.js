(function($){

    console.log('msg');
    
    $(".btn-print").on('click',function (e) {
         e.preventDefault();
         
            window.print();
        });
    $("form[data-confirm]").submit(function() {
        if ( ! confirm($(this).attr("data-confirm"))) {
            return false;
        }
    });

    $("input[name='cita']").change(function() {

        
            if ($(this).val() == '1') {
                $("input[name='cita_date']").attr('disabled', false).focus();
                

            } else {
                  $("input[name='cita_date']").attr('disabled', true);
                  $("input[name='cita_date']").val('');
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

     $("select[name='debts']").change(function() {

      
            if ($(this).val() === '4') {
                $("input[name='debts_amount']").attr('disabled', false).focus();
                

            } else {
                  $("input[name='debts_amount']").attr('disabled', true);
                  $("input[name='debts_amount']").val('0');
            }
        });



    $("select[name='documents']").change(function() {

      
            if ($(this).val() === '0') {
                $("textarea[name='documents_text']").attr('disabled', false).focus();
                

            } else {
                  $("textarea[name='documents_text']").attr('disabled', true);
                  $("textarea[name='documents_text']").val('');
            }
        });

     $("select[name='fiador']").change(function() {

      
            if ($(this).val() === '1') {
                $("textarea[name='fiador_text']").attr('disabled', false).focus();
                

            } else {
                  $("textarea[name='fiador_text']").attr('disabled', true);
                  $("textarea[name='fiador_text']").val('');
            }
        });
   

    var chkItem = $('.chk-item');
    var chkSelectAll = $('#select-all');
    var btnDeleteMultiple = $('.delete-multiple');

   chkSelectAll.on('click',function(e) {

        var c = this.checked;
        $(':checkbox').prop('checked',c);


    });
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
        debts = $('#debts'),
        project = $('#project'),
        potencial = $('#potencial'),
        month = $('#month'),
        currency = $('#currency'),
        cita = $('#cita'),
        order = $('#order'),
        reservation_paid = $('#reservation_paid'),
        filters = $(".filtros");
        
    function submitForm(){
        filters.find('form').submit();
    }

    filters.find('input[name="q"]').on('keydown', function(e){
       if(e.keyCode == 13){
         submitForm();
       }
    });

    status.change(submitForm);
    province.change(submitForm);
    referred.change(submitForm);
    sellers.change(submitForm);
    debts.change(submitForm);
    potencial.change(submitForm);
    project.change(submitForm);
    month.change(submitForm);
    currency.change(submitForm);
    cita.change(submitForm);
    order.change(submitForm);
    reservation_paid.change(submitForm);

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
                    '<span class="label label-success">'+ users[i].name +'</span><input type="hidden" name="sellers" value="'+users[i].id +'"/> </li>');

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


    var selectProject = $('select#project'),
        selectProperties = $('#selectProperties');

   
    
    selectProject.change(function() {
        var $this =  $(this);
       
        selectProperties.empty();
        

         $.ajax({

            url : '/project/properties/list',
            dataType : 'json',
            data : { project_id: $(this).val(), client_id: ($('input[name=client_id]').val()) ? $('input[name=client_id]').val() : 0 }

        }).done(function function_name(resp) {
            console.log(resp);


                
            $.each(resp, function(index,item) {

                selectProperties.append('<option value=' + item.id + '>' + item.name + '</option>');
            });

            selectProperties.trigger("chosen:updated");
           
        });
       
    });

    var selectBank = $('select#bank'),
        selectBank2 = $('select#bank2'),
        selectRequirements = $('#selectedRequirements');
        selectRequirements2 = $('#selectedRequirements2');

   
    
    selectBank.change(function() {
        var $this =  $(this);
       
        selectRequirements.empty();
        

         $.ajax({

            url : '/bank/requirements/list',
            dataType : 'json',
            data : { bank_id: $(this).val() }

        }).done(function function_name(resp) {
            console.log(resp);


                
            $.each(resp, function(index,item) {

                selectRequirements.append('<option value=' + item.id + '>' + item.name + '</option>');
            });

            selectRequirements.trigger("chosen:updated");
           
        });
       
    });
     selectBank2.change(function() {
        var $this =  $(this);
       
        selectRequirements2.empty();
        

         $.ajax({

            url : '/bank/requirements/list',
            dataType : 'json',
            data : { bank_id: $(this).val() }

        }).done(function function_name(resp) {
            console.log(resp);


                
            $.each(resp, function(index,item) {

                selectRequirements2.append('<option value=' + item.id + '>' + item.name + '</option>');
            });

            selectRequirements2.trigger("chosen:updated");
           
        });
       
    });

     $('#comments-list').on('click','.updateComment', function(event) {
        event.preventDefault();
        
        var id = $(this).data('id');
        var comments = $('textarea[name="comments-item-'+ id +'"]').val();
        
        if(comments ==='' || comments === undefined) 
            return false;

        if($(this).data('id') == '0' || $(this).data('id') == '') 
            return false;

         $.ajax({

            method: 'PUT',
            url : '/clients/comments/update',
            dataType : 'json',
            data : { id: $(this).data('id'), body: comments }

        }).done(function function_name(resp) {
            console.log(resp);


             var commentsItems = $.map(resp ,function(obj, index){
                return {
                    id : obj.id,
                    body : obj.body,
                    client_id : obj.client_id,
                    created_at : obj.created_at,
                    user : (obj.user) ? obj.user.name : '',
                   

                }

            });

             var templateHtml = $.trim( $('#commentsListTemplate').html() );

            var template = Handlebars.compile( templateHtml );

            var html = template(commentsItems);
            
            

            $('#comments-list').html( html );
                
            $('#comments').val(''); 
           
        });


      });

      $('#comments-list').on('click','.btn-delete-comment', function(event) {
        event.preventDefault();

         if($(this).data('id') == '0' || $(this).data('id') == '')
         {
            $(this).parent('li').remove();
            return false;
         }


                 $.ajax({

                    method: 'POST',
                    url : '/clients/comments/delete',
                    dataType : 'json',
                    data : { id: $(this).data('id') }

                }).done(function function_name(resp) {
                    console.log(resp);


                     var commentsItems = $.map(resp ,function(obj, index){
                        return {
                            id : obj.id,
                            body : obj.body,
                            client_id : obj.client_id,
                            created_at : obj.created_at,
                            user : (obj.user) ? obj.user.name : '',
                           

                        }

                    });

                     var templateHtml = $.trim( $('#commentsListTemplate').html() );

                    var template = Handlebars.compile( templateHtml );

                    var html = template(commentsItems);
                    
                    

                    $('#comments-list').html( html );
                        
                    $('#comments').val(''); 
                   
                });
        


      });

     $('#saveComment').on('click', function(event) {
        event.preventDefault();

        var comments = $('#comments').val();

        if(comments ==='') 
            return false;

        if($(this).data('client'))
        {
             $.ajax({

                method: 'POST',
                url : '/clients/comments',
                dataType : 'json',
                data : { client_id: $(this).data('client'), body: comments }

            }).done(function function_name(resp) {
                console.log(resp);


                 var commentsItems = $.map(resp ,function(obj, index){
                   
                    return {
                        id : obj.id,
                        body : obj.body,
                        created_at : obj.created_at,
                        user : (obj.user) ? obj.user.name : '',
                       

                    }

                });

                 var templateHtml = $.trim( $('#commentsListTemplate').html() );

                var template = Handlebars.compile( templateHtml );

                var html = template(commentsItems);
                
                

                $('#comments-list').html( html );
                    
                $('#comments').val(''); 
               
            });
        }else{
            var commentsItems = [];
            
            $("#comments-list li").each(function() {
               
                    var com = {
                        id : 0,
                        body : $(this).find('input[name="commentsfromcreate[]"]').val(),
                        created_at : '',
                        user : ''
                       

                        }

                    commentsItems.push(com);
            });

           

             var com = {
                        id : 0,
                        body : comments,
                        created_at : '',
                        user : ''
                       

                    }

             commentsItems.push(com);
            
                  
                    

             

                 var templateHtml = $.trim( $('#commentsListTemplate').html() );

                var template = Handlebars.compile( templateHtml );

                var html = template(commentsItems);
                
                

                $('#comments-list').html( html );
                    
                $('#comments').val(''); 
        }

    });


     // abonos
      $('#abonos-list').on('click','.updateAbono', function(event) {
        event.preventDefault();
        
        var id = $(this).data('id');
        var abono = $('input[name="abonos-item-'+ id +'"]').val();
        var description = $('input[name="description-item-'+ id +'"]').val();
        
        if(abono ==='' || abono === undefined) 
            return false;

        if(id == '0' || id == '') 
            return false;

         $.ajax({

            method: 'PUT',
            url : '/clients/abonos/update',
            dataType : 'json',
            data : { id: id, amount: abono, description: description }

        }).done(function function_name(resp) {
            console.log(resp);


             var abonosItems = $.map(resp ,function(obj, index){
                return {
                    id : obj.id,
                    amount : obj.amount,
                    description : obj.description,
                    client_id : obj.client_id,
                    created_at : obj.created_at,
                   

                }

            });

             var templateHtml = $.trim( $('#abonosListTemplate').html() );

            var template = Handlebars.compile( templateHtml );

            var html = template(abonosItems);
            
            

            $('#abonos-list').html( html );
                
            $('#amount').val('');
            $('#abono-description').val('');  
           
        });


      });

      $('#abonos-list').on('click','.btn-delete-abono', function(event) {
        event.preventDefault();

        if($(this).data('id') == '0' || $(this).data('id') == '')
         {
            $(this).parent('li').remove();
            return false;
         }

         $.ajax({

            method: 'POST',
            url : '/clients/abonos/delete',
            dataType : 'json',
            data : { id: $(this).data('id') }

        }).done(function function_name(resp) {
            console.log(resp);


             var abonosItems = $.map(resp ,function(obj, index){
                return {
                    id : obj.id,
                    amount : obj.amount,
                    description : obj.description,
                    client_id : obj.client_id,
                    created_at : obj.created_at
                   

                }

            });

             var templateHtml = $.trim( $('#abonosListTemplate').html() );

            var template = Handlebars.compile( templateHtml );

            var html = template(abonosItems);
            
            

            $('#abonos-list').html( html );
                
            $('#amount').val(''); 
            $('#abono-description').val('');  
           
        });


      });

     $('#saveAbono').on('click', function(event) {
        event.preventDefault();

        var abono = $('#amount').val();
        var description = $('#abono-description').val();

        if(abono ==='') 
            return false;

        if($(this).data('client'))
        {
             $.ajax({

                method: 'POST',
                url : '/clients/abonos',
                dataType : 'json',
                data : { client_id: $(this).data('client'), amount: abono, description: description }

            }).done(function function_name(resp) {
                console.log(resp);


                 var abonosItems = $.map(resp ,function(obj, index){
                    return {
                        id : obj.id,
                        description: obj.description,
                        amount : obj.amount,
                        created_at : obj.created_at
                       

                    }

                });

                 var templateHtml = $.trim( $('#abonosListTemplate').html() );

                var template = Handlebars.compile( templateHtml );

                var html = template(abonosItems);
                
                

                $('#abonos-list').html( html );
                    
                $('#amount').val('');
                $('#abono-description').val('');  
               
            });
        }else{
            
            var abonosItems = [];
            
            $("#abonos-list li").each(function() {
                var result = $(this).find('input[name="abonosfromcreate[]"]').val().split('|');
                var amount = result[0];
                var desc = result[1];
                    
                var abon = {
                    id : 0,
                    description: desc,
                    amount : amount,
                    created_at : ''
                   
                   

                    }

                    abonosItems.push(abon);
            });

           

             var abon = {
                    id : 0,
                    description: description,
                    amount : abono,
                    created_at : ''
                   
                   

                    }

             abonosItems.push(abon);

                
               var templateHtml = $.trim( $('#abonosListTemplate').html() );

                var template = Handlebars.compile( templateHtml );

                var html = template(abonosItems);
                
                

                $('#abonos-list').html( html );
                    
                $('#amount').val('');
                $('#abono-description').val('');  
        }

    });



     //files
     var filesList = $('#files-list'),
        infoBox = $('#InfoBox'),
        files  = 0,
        inputsFiles = $("#inputs_files");

    $("#add_input_file").on('click', function (e) {
        files++;

        inputsFiles.append('<div><strong>Archivo ' + files + ': </strong>'+
        '<input type="file" name="new_file_file[]" size="45" /></div><br />');

    });
    function deleteFile()
    {
        var btn_delete = $(this),
            url = "/files/" + btn_delete.attr("data-file");

        $.post(url,{_token: $('input[name=_token]').val()}, function(data){
            btn_delete.parent().fadeOut("slow");
        });
    }

    $("#UploadButton").ajaxUpload({
        url : "/files",
        name: "file",
        data: {id: $('input[name=client_id]').val(), _token: $('input[name=_token]').val() },
        onSubmit: function() {
            infoBox.html('Uploading ... ');
        },
        onComplete: function(result) {

            infoBox.html('Uploaded succesfull!');

            var files = jQuery.parseJSON(result);


            fillFilesInfo(files);

            filesList.find('li').find('.delete').on('click',deleteFile);


        }
    });

    filesList.find('li').find('.delete').on('click',deleteFile);

    function fileTemplate(file)
    {

        var templateHtml = $.trim( $('#fileTemplate').html() );

        var template = Handlebars.compile( templateHtml );

        return template(file);

    }


    function fillFilesInfo(jsonData) {
        if (jsonData.error) {
            return onError();
        }

        var html = fileTemplate(jsonData);

        (filesList.length === 0) ? filesList.html( html ) : filesList.prepend(html);

        filesList.find('li').eq(0).hide().show("slow");

    }





})(jQuery);