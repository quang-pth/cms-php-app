function loadUserOnline() {
  $.get('functions.php?users_online=result', function (data) {
    console.log(data)
  })
}

loadUserOnline()
