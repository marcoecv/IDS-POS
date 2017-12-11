<?php $this->Html->script('admin/cashier/cashier', array('inline' => false)); ?>

<?php
$this->assign('title', 'Depositar / Retirar');

?>


<div id="wrap">
    <h2>Donation Form</h2>

    <h3>Demo thanks to Casey Zumwalt of <a href="http://simplefocus.com/">SimpleFocus</a></h3>
    <br>

    <form action="#">
        <div class="fieldset-standard">
            <fieldset>

                <div class="fieldset-grouping">
                    <label for="first-name">First Name</label>
                    <input type="text" id="first-name" name="first-name" value="">
                </div>


                <div class="submit-grouping">
                    <input type="submit" value="Pay Now">
                </div>

            </fieldset>
        </div>
    </form>
</div>

<div>

    <div name="normal" class="aa ui-keyboard-keyset ui-keyboard-keyset-normal" style="display: inline-block;">
        <button id="7" role="button" type="button" aria-disabled="false" tabindex="-1"
                class="key-button-dep" data-value="7" data-name="7"
                data-pos="0,0" data-action="7" data-html="<span class=&quot;ui-keyboard-text&quot;>7</span>"><span
                class="ui-keyboard-text">7</span></button>
        <button role="button" type="button" aria-disabled="false" tabindex="-1"
                class="key-button-dep" data-value="8" data-name="8"
                data-pos="0,1" data-action="8" data-html="<span class=&quot;ui-keyboard-text&quot;>8</span>"><span
                class="ui-keyboard-text">8</span></button>
        <button role="button" type="button" aria-disabled="false" tabindex="-1"
                class="key-button-dep" data-value="9" data-name="9"
                data-pos="0,2" data-action="9" data-html="<span class=&quot;ui-keyboard-text&quot;>9</span>"><span
                class="ui-keyboard-text">9</span></button>
        <br class="ui-keyboard-button-endrow">
        <button role="button" type="button" aria-disabled="false" tabindex="-1"
                class="key-button-dep" data-value="4" data-name="4"
                data-pos="1,0" data-action="4" data-html="<span class=&quot;ui-keyboard-text&quot;>4</span>"><span
                class="ui-keyboard-text">4</span></button>
        <button role="button" type="button" aria-disabled="false" tabindex="-1"
                class="key-button-dep" data-value="5" data-name="5"
                data-pos="1,1" data-action="5" data-html="<span class=&quot;ui-keyboard-text&quot;>5</span>"><span
                class="ui-keyboard-text">5</span></button>
        <button role="button" type="button" aria-disabled="false" tabindex="-1"
                class="key-button-dep" data-value="6" data-name="6"
                data-pos="1,2" data-action="6" data-html="<span class=&quot;ui-keyboard-text&quot;>6</span>"><span
                class="ui-keyboard-text">6</span></button>
        <br class="ui-keyboard-button-endrow">
        <button role="button" type="button" aria-disabled="false" tabindex="-1"
                class="key-button-dep" data-value="1" data-name="1"
                data-pos="2,0" data-action="1" data-html="<span class=&quot;ui-keyboard-text&quot;>1</span>"><span
                class="ui-keyboard-text">1</span></button>
        <button role="button" type="button" aria-disabled="false" tabindex="-1"
                class=key-button-dep" data-value="2" data-name="2"
                data-pos="2,1" data-action="2" data-html="<span class=&quot;ui-keyboard-text&quot;>2</span>"><span
                class="ui-keyboard-text">2</span></button>
        <button role="button" type="button" aria-disabled="false" tabindex="-1"
                class="key-button-dep" data-value="3" data-name="3"
                data-pos="2,2" data-action="3" data-html="<span class=&quot;ui-keyboard-text&quot;>3</span>"><span
                class="ui-keyboard-text">3</span></button>
        <br class="ui-keyboard-button-endrow">
        <button role="button" type="button" aria-disabled="false" tabindex="-1"
                class="key-button-dep" data-value="0" data-name="0"
                data-pos="3,0" data-action="0" data-html="<span class=&quot;ui-keyboard-text&quot;>0</span>"><span
                class="ui-keyboard-text">0</span></button>
        <button role="button" type="button" aria-disabled="false" tabindex="-1"
                class="key-button-dep"
                data-value="bksp" data-name="bksp" data-pos="3,1" data-action="bksp"
                data-html="<span class=&quot;ui-keyboard-text&quot;>Bksp</span>" data-title="Backspace"
                title="Backspace"><span class="ui-keyboard-text">Bksp</span></button>
        <br class="ui-keyboard-button-endrow">
        <button role="button" type="button" aria-disabled="false" tabindex="-1"
                class="ui-keyboard-button ui-keyboard-actionkey ui-keyboard-accept ui-keyboard-widekey ui-state-default ui-corner-all ui-state-active"
                data-value="accept" data-name="accept" data-pos="4,0" data-action="accept"
                data-html="<span class=&quot;ui-keyboard-text&quot;>Accept</span>" data-title="Accept (Shift+Enter)"
                title="Accept (Shift+Enter)"><span class="ui-keyboard-text">Accept</span></button>
        <br class="ui-keyboard-button-endrow"></div>

</div>

<script>
    $(document).on('click', '.key-button-dep', function (e) {
        //e.preventDefault();
        //$(this).addClass(settings.btnActiveClasses);
        var keyContent = $(this).attr('data-value');
        var parent = $('[aria-describedby=' + $(this).closest('.popover').attr('id') + ']');
        var currentContent = $('#first-name').val();
        switch (keyContent) {
            case 'bksp':
                currentContent = currentContent.substr(0, currentContent.length - 1);
                break;
            default:
                currentContent += keyContent;
            //keyboardShift=false;
        }
        $('#first-name').val(currentContent);
        //keyboardShiftify();
        parent.focus();
    });


</script>



