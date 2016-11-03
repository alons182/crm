<div id="modalAddClient" class="modal fade bs-modal-sm" tabindex="-1" role="dialog" aria-hidden="true" data-url="/sellers/list">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h5 class="modal-title text-center" id="myModalLabel">Vendedor</h5>
            </div>
            <div class="modal-body">
                <form class="navbar-form navbar-search navbar-left dropdown " role="search">
                    <div class="form-group">

                        <input id="searchText" type="text" class="form-control search-query dropdown-toggle " data-toggle="dropdown" placeholder="Buscar" autocomplete="off">
                    </div>

                </form>
                <table class="table table-striped  ">
                    <thead>
                    <tr>
                        <th>=</th>
                        <th>#</th>
                        <th>Nombre</th>

                    </tr>
                    </thead>
                    <tbody class="tbody">

                    </tbody>
                    <tfoot>
                    <tr>
                        <td  colspan="10" class="pagination-container">
                            <ul class="pagination"></ul>
                        </td>
                    </tr>


                    </tfoot>
                </table>
                <script id="usersTemplate" type="text/x-handlebars-template">
                    @{{#each this}}
                    <tr>
                        <td class="@{{ class }}"> <input type="radio" name="chkUsers" value="@{{ id }}" /></td>
                        <td>@{{ id }}</td>
                        <td>@{{ name }}</td>

                    </tr>
                    @{{/each}}


                </script>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn bg-default btn-sm" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary btn-sm">Agregar</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
