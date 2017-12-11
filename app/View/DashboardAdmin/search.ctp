<?php $this->Html->css('admin/search', array('inline' => false)); ?>
<?php echo $this->element('DashboardAdmin/topmenu_search'); ?>

<div class="container-fluid" id="search">
    <div class="col-md-12 wrap-table">
        <div class="table col-sm-12">
            <div class="table-row th">
                <div class="table-cell"><?php echo __('Customer');?></div>
                <div class="table-cell"><?php echo __('First Name');?></div>
                <div class="table-cell"><?php echo __('Last Name');?></div>
                <div class="table-cell"><?php echo __('Email');?></div>
                <div class="table-cell"><?php echo __('Adress');?></div>
                <div class="table-cell"><?php echo __('City');?></div>
                <div class="table-cell"><?php echo __('Phone Mobil');?></div>
                <div class="table-cell"><?php echo __('Phone Home');?></div>
                <div class="table-cell"><?php echo __('Password');?></div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function(){
        $('#header .dropdown-toggle.filtre').bind('click', function(){
            var parent = $(this).parent('.input-group-btn');
            if (parent.hasClass('open')) {
                $(this).parent('.input-group-btn').removeClass('open');
            }else{
                $(this).parent('.input-group-btn').addClass('open');
            }
        });
        
        // Event Find
        $('#header #btn-find').bind('click', function(){
            $(this).parent('.input-group-btn').removeClass('open');
             
            var filter = $("#header input[name=checkbox-filtre]:checked").val();
            var searchWord =  $.trim($('#header #word').val());
            
            /*
            var agent = ($('#header #filtre_player').prop('checked') ) ? true:false;
            var player = ($('#header #filtre_agent').prop('checked')) ? true:false;
            
            var searchIn=new Array('CustomerId');
            
            
            if($('#header #filtre_fname').prop('checked')) { searchIn.push('NameLast');};
            if($('#header #filtre_lname').prop('checked')) { searchIn.push('NameFirst');}; 
            if($('#header #filtre_email').prop('checked')) { searchIn.push('EMail');}; 
            if($('#header #filtre_adress').prop('checked')) { searchIn.push('Address');}; 
            if($('#header #filtre_city').prop('checked')) { searchIn.push('City');}; 
            if($('#header #filtre_mphone').prop('checked')) { searchIn.push('BusinessPhone');}; 
            if($('#header #filtre_hmobile').prop('checked')) { searchIn.push('HomePhone');};
            if($('#header #filtre_pw').prop('checked')) { searchIn.push('Password');}; 
            searchInStr = searchIn.join(',');
            */
            if (isIsset(searchWord) && isIsset(filter) ) {
                $.ajax({
                    type: 'POST',
                    url: '/DashboardAdmin/searchData',
                    dataType: "json",
                    cache: true,
                    data: {
                        searchWord: searchWord,
                        filter:filter
                    },beforeSend: function(){
                        $('#search .table-row.td').remove();
                        $('#search .table').after('<div class="col-md-12 wait">Please wait while we process your request.</div>');
                    },
                    success: function (data) {
                        if (!isIsset(data)) {
                            return;
                        }
                        $('#search .table-row.td').remove();
                        $('#search .table').append(data)
                     },
                     complete: function(){
                        $('#search .wait').remove();
                     },
                     error: function(){
                        $('#search .table-row.td').remove();
                        $('#search .table').append('<div class="table-row td">Error query.</div>');
                     }
                });
            }
      
        });
    });
    
    
    function lnkToPersonal(id){           
        $(location).attr('href','/Personal/index/'+id);
    }
   
</script>

