<style type="text/css">
    #rsvp-form ul {
        margin: 0;
        padding: 20px 0;
    }
    #rsvp-form ul li {
        margin: 0;
        list-style: none;
    }
    #rsvp-form label {
        width: 190px;
        display: block;
        float: left;
        margin-top: 5px;
    }
    #rsvp-form input.text,
    #rsvp-form textarea {
        float: left;
        display: block;
        width: 300px;
        margin-right: 5px;
    }
    #rsvp-form textarea {
        height: 100px;
    }
    .clear {
        clear: both;
    }
    .rsvp-notice {
        padding: 20px;
        font-size: 24px;
        color: #fff;
    }
    .rsvp-success {
        background: #59a757;
        text-shadow: 1px 1px 0 #378035;
    }
    .rsvp-error {
        background: #b84040;
        text-shadow: 1px 1px 0 #8d3030;
    }
</style>
<form id="rsvp-form">
    <ul>
        <li>
            <label>Are you coming?</label>
            <input type="radio" id="rsvp-coming-yes" name="rsvp-coming" checked="checked" /> Yes &nbsp;&nbsp;
            <input type="radio" id="rsvp-coming-no" name="rsvp-coming" /> No
            <div class="clear"></div>
        </li>
        <li>
            <label for="rsvp-name">Your full name</label>
            <input type="text" class="text" id="rsvp-name" />
            <div class="clear"></div>
        </li>
        <li>
            <label for="rsvp-email">Your email</label>
            <input type="text" class="text" id="rsvp-email" />
            <div class="clear"></div>
        </li>
        <li class="coming-li">
            <label>Are you vegetarian?</label>
            <input type="radio" id="rsvp-vegetarian-yes" name="rsvp-vegetarian" /> Yes &nbsp;&nbsp;
            <input type="radio" id="rsvp-vegetarian-no" name="rsvp-vegetarian" checked="checked"  /> No
            <div class="clear"></div>
        </li>
        <li id="guests-li" class="coming-li">
            <label for="rsvp-guests">Guests?</label>
            <select id="rsvp-guests">
                <option value="0">I'm coming alone.</option>
                <option value="1">I'm bringing myself plus 1 guest.</option>
                <option value="2">I'm bringing myself plus 2 guests.</option>
                <option value="3">I'm bringing myself plus 3 guests.</option>
                <option value="4">I'm bringing myself plus 4 guests.</option>
            </select>
            <div class="clear"></div>
        </li>
        <li class="coming-li">
            <label for="rsvp-allergies">Any food allergies?</label>
            <textarea id="rsvp-allergies"></textarea>
            <div class="clear"></div>
        </li>
        <li>
            <label>&nbsp;</label>
            <input type="submit" class="submit" value="Submit" />
            <div class="clear"></div>
        </li>
    </ul>
</form>

<script type="text/template" id="guest-tpl">
    <li class="coming-li guest-full-name">
        <label>Guest #{{ num }} full name</label>
        <input type="text" class="text guest-full-name-input" />
        <input type="checkbox" class="guest-vegetarian-input" /> Vegetarian
        <div class="clear"></div>
    </li>
</script>

<script type="text/javascript">
    jQuery(function($){

        $('#rsvp-coming-yes, #rsvp-coming-no').click(function(){
            var method = $(this).attr('id') == 'rsvp-coming-no' ? 'hide' : 'show';
            $('.coming-li')[method]();
        });

        $('#rsvp-guests').change(function(){
            var val = this.value;
            var tpl = $('#guest-tpl').html();
            var html = '';

            $('.guest-full-name').remove();

            var $guests_li = $('#guests-li');
            for(var i = 0; i < val; i++){
                html += tpl.replace('{{ num }}', i + 1);
            }

            $guests_li.after(html);
        });

        $('#rsvp-form input.submit').click(function(e){

            var vegetarian = $('#rsvp-vegetarian-yes').is(':checked') ? 1 : 0;
            var $guest_inputs = $('#rsvp-form .guest-full-name-input');
            var empty_guest = false;
            var coming = $('#rsvp-coming-yes').is(':checked') ? 1 : 0;

            if($.trim($('#rsvp-name').val()) == ''){
                alert('You need to fill our your full name');
                return false;
            }

            $guest_inputs.each(function(){
                if($(this).val() == ''){
                    empty_guest = true;
                }
            });

            if(empty_guest && $guest_inputs.filter(':visible').length){
                alert('You need to fill in all the guest full names');
                return false;
            }

            var $submit = $(this);
            var orig_submit_val = $submit.val();
            $submit.val('Submitting... Please wait...').attr('disabled', 'disabled');

            var guests = [];
            $guest_inputs.each(function(){
                guests.push({
                    vegetarian: $(this).parents('li').find('.guest-vegetarian-input').is(':checked') ? 1 : 0,
                    full_name: $(this).val()
                })
            });

            var data = {
                coming: coming,
                full_name: $('#rsvp-name').val(),
                vegetarian: vegetarian,
                email: $('#rsvp-email').val(),
                allergies: $('#rsvp-allergies').val(),
                guests: guests
            };

            $.ajax({
                url: '<? get_bloginfo('home'); ?>?rsvp=1',
                data: data,
                dataType: 'json',
                type: 'GET',
                success: function(res){
                    var cls = res.status;
                    if(cls == 'success'){
                        $('#rsvp-form').replaceWith('<div class="rsvp-' + cls + ' rsvp-notice">' + res.message + '</div>');
                    } else {
                        alert(res.message);
                        $submit.val(orig_submit_val).removeAttr('disabled');
                    }
                    window.location.hash = 'rsvp';
                }
            });

            return false;
        });

    });
</script>