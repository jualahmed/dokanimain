<<<<<<< HEAD
define(function () {
  // German
  return {
    inputTooLong: function (args) {
      var overChars = args.input.length - args.maximum;

      return 'Bitte ' + overChars + ' Zeichen weniger eingeben';
    },
    inputTooShort: function (args) {
      var remainingChars = args.minimum - args.input.length;

      return 'Bitte ' + remainingChars + ' Zeichen mehr eingeben';
    },
    loadingMore: function () {
      return 'Lade mehr Ergebnisse…';
    },
    maximumSelected: function (args) {
      var message = 'Sie können nur ' + args.maximum + ' Eintr';

      if (args.maximum === 1) {
        message += 'ag';
      } else {
        message += 'äge';
      }

      message += ' auswählen';

      return message;
    },
    noResults: function () {
      return 'Keine Übereinstimmungen gefunden';
    },
    searching: function () {
      return 'Suche…';
    }
  };
});
=======
define(function () {
  // German
  return {
    inputTooLong: function (args) {
      var overChars = args.input.length - args.maximum;

      return 'Bitte ' + overChars + ' Zeichen weniger eingeben';
    },
    inputTooShort: function (args) {
      var remainingChars = args.minimum - args.input.length;

      return 'Bitte ' + remainingChars + ' Zeichen mehr eingeben';
    },
    loadingMore: function () {
      return 'Lade mehr Ergebnisse…';
    },
    maximumSelected: function (args) {
      var message = 'Sie können nur ' + args.maximum + ' Eintr';

      if (args.maximum === 1) {
        message += 'ag';
      } else {
        message += 'äge';
      }

      message += ' auswählen';

      return message;
    },
    noResults: function () {
      return 'Keine Übereinstimmungen gefunden';
    },
    searching: function () {
      return 'Suche…';
    }
  };
});
>>>>>>> 126491c5b956413b4ebc35a0628acbc4d375a4e7
