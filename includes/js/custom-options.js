jQuery(document).ready(function($) {
    var container = $('#global-variables-container');

    $('#add-variable').click(function(e) {
        e.preventDefault();
        var index = container.children().length;
        var template = `
            <div class="global-variable">
                <input type="text" name="global_variables[${index}][label]" placeholder="Label" />
                <select name="global_variables[${index}][type]">
                    <option value="text">Text String</option>
                    <option value="email">Email</option>
                    <option value="url">URL</option>
                </select>
                <input type="text" name="global_variables[${index}][value]" placeholder="Value" />
                <button class="remove-variable"><svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 122.88 122.88" style="enable-background:new 0 0 122.88 122.88" xml:space="preserve"><style type="text/css">.st0{fill-rule:evenodd;clip-rule:evenodd;}</style><g><path class="st0" d="M1.63,97.99l36.55-36.55L1.63,24.89c-2.17-2.17-2.17-5.73,0-7.9L16.99,1.63c2.17-2.17,5.73-2.17,7.9,0 l36.55,36.55L97.99,1.63c2.17-2.17,5.73-2.17,7.9,0l15.36,15.36c2.17,2.17,2.17,5.73,0,7.9L84.7,61.44l36.55,36.55 c2.17,2.17,2.17,5.73,0,7.9l-15.36,15.36c-2.17,2.17-5.73,2.17-7.9,0L61.44,84.7l-36.55,36.55c-2.17,2.17-5.73,2.17-7.9,0 L1.63,105.89C-0.54,103.72-0.54,100.16,1.63,97.99L1.63,97.99z"/></g></svg></button>
            </div>
        `;
        container.append(template);
    });

    container.on('click', '.remove-variable', function(e) {
        e.preventDefault();
        var confirmRemove = confirm('Do you really want to delete this variable?');
        if (confirmRemove) {
            $(this).parent().remove();
            updateShortcodeDisplay();
        }
    });
    
    function updateShortcodeDisplay() {
        $('.global-variable').each(function() {
            var title = $(this).find('input[name$="[label]"]').val();
            var sanitizedTitle = sanitizeTitleForShortcode(title);
            $(this).find('.shortcode-display').val('[gvar title="' + sanitizedTitle + '"]');
        });
    }

    container.on('click', '.copy-shortcode', function(e) {
        e.preventDefault();
        var shortcode = $(this).prev('.shortcode-display').val();
        
        // Create a temporary input element
        var tempInput = $('<input>');
        $('body').append(tempInput);
        tempInput.val(shortcode).select();
        
        // Copy the shortcode to the clipboard
        navigator.clipboard.writeText(shortcode).then(() => {
            console.log('Text copied to clipboard successfully!');
        }).catch(err => {
            console.error('Failed to copy text: ', err);
        });
        
        // Remove the temporary input element
        tempInput.remove();
    });

});