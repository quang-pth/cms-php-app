function loadUserOnline() {
  $.get('functions.php?onlineusers=result', function (data) {
    console.log(data)
  })
}

setInterval(function () {
  loadUserOnline()
}, 300)
