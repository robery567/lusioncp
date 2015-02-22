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
                        <?php
                        $query = "
                            SELECT
                                *
                            FROM
                                lcpc_files
                        ";
                        $getsf = $db->query($query);

                        if(isset($_POST['send']) && isset($_POST['doublecheck'])) {
                            warning("Comanda a fost trimisa. Va rugam asteptati...");
                            $date = date("dmY_his");

                            $remote->cmdExec('./usr/home/metin2/stop.sh');
                            $remote->cmdExec('./usr/home/metin2/clear.sh');
                            $remote->cmdExec('service mysql-server stop');

                            $clean_cmd = [
                                'files' => 'cd /usr/home && rm -rf *',
                                'datab' => 'cd /var/db/mysql && rm -rf *'
                            ];

                            $install_cmd = [
                                'files' => 'cd /root/lcp/temp && tar -xzf server_*.tar.gz && mv server_* /usr/home',
                                'datab' => 'cd /root/lcp/temp && tar -xzf db_*.tar.gz && mv db_* /var/db',
                            ];

                            $download_cmd = [
                                'files' => 'cd /root/lcp/temp && fetch --no-verify-peer '.$getsf->file_url,
                                'datab' => 'cd /root/lcp/temp && fetch --no-verify-peer '.$getsf->db_url
                            ];

                            $backup_cmd = [
                                'files' => 'cd /root/lcp/backup && tar -czf /usr/home/* bkp_home_'.$date.'.tar.gz',
                                'datab' => 'cd /root/lcp/backup && tar -czf /var/db/mysql bkp_db_'.$date.'.tar.gz'
                            ];

                            foreach($backup_cmd as $type => $command) {
                                $remote->cmdExec($command);
                            }
                            foreach($clean_cmd as $type => $command) {
                                $remote->cmdExec($command);
                            }
                            foreach($download_cmd as $type => $command) {
                                $remote->cmdExec($command);
                            }
                            foreach($install_cmd as $type => $command) {
                                $remote->cmdExec($command);
                            }

                            $remote->cmdExec('cd /root/lcp && rm -rf temp');
                            $remote->cmdExec('echo "'.$getsf->file_name.'" > /root/lcp/lastsf');

                            $remote->cmdExec('service mysql-server start');
                            $remote->cmdExec('./usr/home/metin2/start.sh');
                        } else {
                            trigger_error('<strong>ATENȚIE!</strong> Instalarea poate dura pana la 10 minute. Aveti rabdare!');
                        }
                        ?>
                        <div class="table-responsive">
                            <?php
                            $cached_filename = $remote->cmdExec('cat /root/lcp/lastsf');
                            $query = "
                                SELECT
                                    *
                                FROM
                                    lcpc_files
                                WHERE
                                    file_name = '{$cached_filename}'
                            ";
                            $special = $db->query($query)->fetch_object();

                            ?>
                            <form action="serverfiles.php?action=install" method="post">
                                <table class="table table-bordered table-hover table-striped">
                                    <tbody>
                                        <tr>
                                            <td>Alege server files:</td>
                                            <td>
                                                <select name="serverfiles" class="btn btn-default btn-xs dropdown-toggle">
                                                    <option value="0" disabled>Ultimul serverfiles instalat:</option>
                                                    <option value="<?= $special->file_id ?>" selected><?= $special->file_name ?></option>
                                                    <option value="0" disabled>Alege alt serverfiles de pe listă:</option>
                                                    <?php while($sf = $getsf->fetch_object()): ?>
                                                    <option value="<?= $sf->file_id ?>"<?php if($sf->file_id == $special->file_id): ?> disabled<?php endif ?>><?= $sf->file_name ?></option>
                                                    <?php endwhile; ?>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Bifează căsuța:</td>
                                            <td><input type="checkbox" name="doublecheck"></td>
                                        </tr>

                                        <tr>
                                            <td>&nbsp;</td>
                                            <td><input type="submit"  class="btn btn-success" name="send" value="Instalează"></td>
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
