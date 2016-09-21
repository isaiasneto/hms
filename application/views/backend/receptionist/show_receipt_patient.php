<table class="table table-bordered table-striped datatable" id="table-2">
    <thead>
        <tr>
            <th class="text-center">#</th>
            <th class="text-center"><?php echo get_phrase('date');?></th>
            <th class="text-center"><?php echo get_phrase('patient');?></th>
            <th class="text-center"><?php echo get_phrase('amount');?></th>
            <th class="text-center"><?php echo get_phrase('options');?></th>
        </tr>
    </thead>

    <tbody>
        <?php
        $system_currency_id = $this->db->get_where('settings', array('type' => 'system_currency_id'))->row()->description;
        $currency_symbol    = $this->db->get_where('currency', array('currency_id' => $system_currency_id))->row()->currency_symbol;
        $count = 1;
        foreach ($receipt_patient_info as $row) { ?>
            <tr>
                <td align="center"><?php echo $count++; ?></td>
                <td align="center"><?php echo date("d/m/Y - H:i", $row['timestamp']);?></td>
                <td><?php echo $row['patient_name'];?></td>
                <td align="center"><?php echo $currency_symbol.number_format($row['receipt_patient_amount'],2,',','.');?></td>
                <td align="center">
                    <a onclick="showAjaxModal('<?php echo base_url();?>index.php?modal/popup/view_receipt_patient/<?php echo $row['receipt_patient_id'];?>');" class="btn btn-default btn-sm btn-icon icon-left">
                        <i class="entypo-eye"></i>
                        <?php echo get_phrase('view_receipt');?>
                    </a>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>

<script type="text/javascript">
    jQuery(window).load(function ()
    {
        var $ = jQuery;

        $("#table-2").dataTable({
            "sPaginationType": "bootstrap",
            "sDom": "<'row'<'col-xs-3 col-left'l><'col-xs-9 col-right'<'export-data'T>f>r>t<'row'<'col-xs-3 col-left'i><'col-xs-9 col-right'p>>",
            "oLanguage": {
            "sEmptyTable": "Nenhum registro encontrado",
                "sInfo": "Mostrando de _START_ até _END_ de _TOTAL_ registros",
                "sInfoEmpty": "Mostrando 0 até 0 de 0 registros",
                "sInfoFiltered": "(Filtrados de _MAX_ registros)",
                "sInfoPostFix": "",
                "sInfoThousands": ".",
                "sLengthMenu": "_MENU_ resultados por página",
                "sLoadingRecords": "Carregando...",
                "sProcessing": "Processando...",
                "sZeroRecords": "Nenhum registro encontrado",
                "sSearch": "Pesquisar",
                "oPaginate": {
                    "sNext": "Próximo",
                    "sPrevious": "Anterior",
                    "sFirst": "Primeiro",
                    "sLast": "Último"
                },
                "oAria": {
                    "sSortAscending": ": Ordenar colunas de forma ascendente",
                    "sSortDescending": ": Ordenar colunas de forma descendente"
                }
            }
        });

        $(".dataTables_wrapper select").select2({
            minimumResultsForSearch: -1
        });

        // Highlighted rows
        $("#table-2 tbody input[type=checkbox]").each(function (i, el)
        {
            var $this = $(el),
                    $p = $this.closest('tr');

            $(el).on('change', function ()
            {
                var is_checked = $this.is(':checked');

                $p[is_checked ? 'addClass' : 'removeClass']('highlight');
            });
        });

        // Replace Checkboxes
        $(".pagination a").click(function (ev)
        {
            replaceCheckboxes();
        });
    });
</script>