
     $(function () {
         jsKeyboard.init("virtualKeyboard");

         //first input focus
         var $firstInput = $('emailAddy').first().focus();
         jsKeyboard.currentElement = $firstInput;
         jsKeyboard.currentElementCursorPosition = 0;
     });