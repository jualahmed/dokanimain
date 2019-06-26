<<<<<<< HEAD
define(function () {
  // Indonesian
  return {
    errorLoading: function () {
      return 'Data tidak boleh diambil.';
    },
    inputTooLong: function (args) {
      var overChars = args.input.length - args.maximum;

      return 'Hapuskan ' + overChars + ' huruf';
    },
    inputTooShort: function (args) {
      var remainingChars = args.minimum - args.input.length;

      return 'Masukkan ' + remainingChars + ' huruf lagi';
    },
    loadingMore: function () {
      return 'Mengambil data…';
    },
    maximumSelected: function (args) {
      return 'Anda hanya dapat memilih ' + args.maximum + ' pilihan';
    },
    noResults: function () {
      return 'Tidak ada data yang sesuai';
    },
    searching: function () {
      return 'Mencari…';
    }
  };
});
=======
define(function () {
  // Indonesian
  return {
    errorLoading: function () {
      return 'Data tidak boleh diambil.';
    },
    inputTooLong: function (args) {
      var overChars = args.input.length - args.maximum;

      return 'Hapuskan ' + overChars + ' huruf';
    },
    inputTooShort: function (args) {
      var remainingChars = args.minimum - args.input.length;

      return 'Masukkan ' + remainingChars + ' huruf lagi';
    },
    loadingMore: function () {
      return 'Mengambil data…';
    },
    maximumSelected: function (args) {
      return 'Anda hanya dapat memilih ' + args.maximum + ' pilihan';
    },
    noResults: function () {
      return 'Tidak ada data yang sesuai';
    },
    searching: function () {
      return 'Mencari…';
    }
  };
});
>>>>>>> 126491c5b956413b4ebc35a0628acbc4d375a4e7
