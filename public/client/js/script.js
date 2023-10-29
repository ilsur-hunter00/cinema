// function selectDay(element) {
//     var allDayElements = document.querySelectorAll('.page-nav__day');
//     allDayElements.forEach(function (dayElement) {
//         dayElement.classList.remove('page-nav__day_chosen');
//     });
//
//     element.classList.add('page-nav__day_chosen');
//
//     localStorage.setItem('selectedDay', element.getAttribute('href'));
// }
//
// document.addEventListener('DOMContentLoaded', function() {
//     var selectedDay = localStorage.getItem('selectedDay');
//
//     if (selectedDay) {
//         var selectedDayElement = document.querySelector(`[href="${selectedDay}"]`);
//         if (selectedDayElement) {
//             selectedDayElement.classList.add('page-nav__day_chosen');
//         }
//     }
// });

function moveToNextDay() {
    const currentSelectedElement = document.querySelector('.page-nav__day_chosen');

    if (currentSelectedElement) {
        const nextDayElement = currentSelectedElement.nextElementSibling;

        if (nextDayElement && !nextDayElement.classList.contains('page-nav__day_next')) {
            currentSelectedElement.classList.remove('page-nav__day_chosen');

            nextDayElement.classList.add('page-nav__day_chosen');

            window.location.href = nextDayElement.getAttribute('href');
        }
    }
}
