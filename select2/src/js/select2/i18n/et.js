<<<<<<< HEAD
define(function () {
  // Estonian
  return {
    inputTooLong: function (args) {
      var overChars = args.input.length - args.maximum;

      var message = 'Sisesta ' + overChars + ' täht';

      if (overChars != 1) {
        message += 'e';
      }

      message += ' vähem';

      return message;
    },
    inputTooShort: function (args) {
      var remainingChars = args.minimum - args.input.length;

      var message = 'Sisesta ' + remainingChars + ' täht';

      if (remainingChars != 1) {
        message += 'e';
      }

      message += ' rohkem';

      return message;
    },
    loadingMore: function () {
      return 'Laen tulemusi…';
    },
    maximumSelected: function (args) {
      var message = 'Saad vaid ' + args.maximum + ' tulemus';

      if (args.maximum == 1) {
        message += 'e';
      } else {
        message += 't';
      }

      message += ' valida';

      return message;
    },
    noResults: function () {
      return 'Tulemused puuduvad';
    },
    searching: function () {
      return 'Otsin…';
    }
  };
});
=======
define(function () {
  // Estonian
  return {
    inputTooLong: function (args) {
      var overChars = args.input.length - args.maximum;

      var message = 'Sisesta ' + overChars + ' täht';

      if (overChars != 1) {
        message += 'e';
      }

      message += ' vähem';

      return message;
    },
    inputTooShort: function (args) {
      var remainingChars = args.minimum - args.input.length;

      var message = 'Sisesta ' + remainingChars + ' täht';

      if (remainingChars != 1) {
        message += 'e';
      }

      message += ' rohkem';

      return message;
    },
    loadingMore: function () {
      return 'Laen tulemusi…';
    },
    maximumSelected: function (args) {
      var message = 'Saad vaid ' + args.maximum + ' tulemus';

      if (args.maximum == 1) {
        message += 'e';
      } else {
        message += 't';
      }

      message += ' valida';

      return message;
    },
    noResults: function () {
      return 'Tulemused puuduvad';
    },
    searching: function () {
      return 'Otsin…';
    }
  };
});
>>>>>>> 126491c5b956413b4ebc35a0628acbc4d375a4e7
