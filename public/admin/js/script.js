const seancesMovieButtons = document.querySelectorAll('.conf-step__seances-movie');
const seancesTimelines = document.querySelectorAll('.conf-step__seances-timeline');
const seancesMovieTimelines = document.querySelectorAll('.conf-step__seances-movie-start');

seancesTimelines.forEach(function(seancesTimeline) {
    const seancesTimelineWidth = seancesTimeline.clientWidth;
    const oneMinuteWidth = seancesTimelineWidth / 1440;

    seancesMovieButtons.forEach(function(seancesMovieButton) {
        const timeString = seancesMovieButton.querySelector('.conf-step__seances-movie-start').textContent;
        const totalMinutes = function () {
            const [hours, minutes] = timeString.split(":");
            return parseInt(hours, 10) * 60 + parseInt(minutes, 10);
        };

        const leftPosition = oneMinuteWidth * totalMinutes();
        seancesMovieButton.style.left = leftPosition + 'px';
    });
});

const buttons = document.querySelectorAll('.conf-step__seances-movie');
const popup = document.getElementById('popup-delete_showtime');
const popupScreeningId = popup.querySelector('#screening-id'); // Поле внутри попапа, куда будем вставлять значение

buttons.forEach(function(button) {
    button.addEventListener('click', function() {
        // Здесь можно использовать Ajax-запрос для получения данных о сеансе с использованием screeningId
        // и вставить их в попап

        // Примерно так можно вставить значение в попап:
        popupScreeningId.value = button.getAttribute('data-screening-id');

        // Откройте попап
        popup.style.display = 'block';
    });
});

function deleteHall(hallId) {
    if (confirm('Вы уверены, что хотите удалить этот зал?')) {
        const form = document.getElementById('deleteHallForm');
        form.submit();
    }
}

