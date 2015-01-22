<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Clienți</h1>
    </div>
</div>
<div class="row">
    <div class="col-lg-8">
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-user fa-fw"></i> Instalare serverfile
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-lg-12">

                        <div class="table-responsive">
                            <form action="add_serverfile.php" method="post">
                                <table class="table table-bordered table-hover table-striped">
                                    <tbody>
                                        <tr>
                                            <td>Nume serverfile:</td>
                                            <td><input type="text" name="file_name"></td>
                                        </tr>
                                        <tr>
                                            <td>URL SERVERFILE:</td>
                                            <td><input type="text" name="file_url"></td>
                                        </tr>
                                        <tr>
                                            <td>DB URL (.tar.gz,.tar format):</td>
                                            <td><input type="text" name="db_url"></td>
                                        </tr>

                                        <tr>
                                            <td>&nbsp;</td>
                                            <td><input type="submit"  class="btn btn-success" name="send" value="Trimite"></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
