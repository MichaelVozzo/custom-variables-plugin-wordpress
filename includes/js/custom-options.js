jQuery(document).ready(function ($) {
  var container = $("#global-variables-container");
  var popup = $('#copied-popup');
  
  // Function to mark existing name fields as readonly
  function markExistingFieldsAsReadonly() {
      $('.global-variable').each(function() {
          var $nameField = $(this).find('input[name$="[label]"]');
          if ($nameField.val()) { // Check if the value is not empty
              $nameField.attr('readonly', 'readonly'); // Mark as readonly
          }
      });
  }
  
  // Call the function on page load
  markExistingFieldsAsReadonly();

  $("#add-variable").click(function (e) {
    e.preventDefault();
    var index = container.children().length;
    var template = `
            <div class="global-variable">
                <input type="text" name="global_variables[${index}][label]" placeholder="Variable Name" />
                <select name="global_variables[${index}][type]">
                    <option value="text">Text String</option>
                    <option value="email">Email</option>
                    <option value="url">URL</option>
                </select>
                <input type="text" name="global_variables[${index}][value]" placeholder="Value" />
                <button class="remove-variable"><img src="/wp-content/plugins/custom-variables-plugin/images/remove.svg" /></button>
            </div>
        `;
    container.append(template);
  });

  container.on("click", ".remove-variable", function (e) {
    e.preventDefault();
    var confirmRemove = confirm("Do you really want to delete this variable?");
    if (confirmRemove) {
      $(this).parent().remove();
      updateShortcodeDisplay();
    }
  });

  function updateShortcodeDisplay() {
    $(".global-variable").each(function () {
      var title = $(this).find('input[name$="[label]"]').val();
      var sanitizedTitle = sanitizeTitleForShortcode(title);
      $(this)
        .find(".shortcode-display")
        .val('[gvar title="' + sanitizedTitle + '"]');
    });
  }

  container.on("click", ".copy-shortcode", function (e) {
    e.preventDefault();
    var shortcode = $(this).prev(".shortcode-display").val();

    // Create a temporary input element
    var tempInput = $("<input>");
    $("body").append(tempInput);
    tempInput.val(shortcode).select();

    // Copy the shortcode to the clipboard
    navigator.clipboard
      .writeText(shortcode)
      .then(() => {
        popup.addClass('show');
        setTimeout(function() {
            popup.removeClass('show');
        }, 1300);
      })
      .catch((err) => {
        console.error("Failed to copy text: ", err);
      });

    // Remove the temporary input element
    tempInput.remove();
  });

  // Form validation JS
  $('form').on('submit', function(e) {
      let isValid = true;
  
      $('.global-variable').each(function() {
          let nameCheck = $(this).find('input[name$="[label]"]').val();
          let type = $(this).find('select[name$="[type]"]').val();
          let value = $(this).find('input[name$="[value]"]').val();
          
          if (nameCheck === ""){
            alert('The Name field is required.');
                isValid = false;
                return false; // Exit each loop
          }
  
          if (type === 'email' && !validateEmail(value)) {
              alert('Invalid email address');
              isValid = false;
              return false; // Exit each loop
          } else if (type === 'url' && !validateURL(value)) {
              alert('Invalid URL');
              isValid = false;
              return false; // Exit each loop
          }
      });
  
      if (!isValid) {
          e.preventDefault(); // Prevent form submission
      }
  });
  
  function validateEmail(email) {
      var re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
      return re.test(String(email).toLowerCase());
  }
  
  function validateURL(url) {
      var re = /^(https?|ftp):\/\/[^\s/$.?#].[^\s]*$/i;
      return re.test(String(url).toLowerCase());
  }
});
