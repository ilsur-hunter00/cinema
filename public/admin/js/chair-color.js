document.addEventListener('DOMContentLoaded', function() {
    const chairs = document.querySelectorAll('.conf-step__chair');

    chairs.forEach(function(chair) {
        chair.addEventListener('click', function() {
            let chairType = 'standart';

            if (chair.classList.contains('conf-step__chair_disabled')) {
                chair.classList.remove('conf-step__chair_disabled');
                chair.classList.add('conf-step__chair_standart');
                chairType = 'standart';
            } else if (chair.classList.contains('conf-step__chair_standart')) {
                chair.classList.remove('conf-step__chair_standart');
                chair.classList.add('conf-step__chair_vip');
                chairType = 'vip';
            } else if (chair.classList.contains('conf-step__chair_vip')) {
                chair.classList.remove('conf-step__chair_vip');
                chair.classList.add('conf-step__chair_disabled');
                chairType = 'disabled';
            }

            updateChairName(chair, chairType);
        });
    });

    function updateChairName(chair, chairType) {
        const i = chair.getAttribute('data-i');
        const j = chair.getAttribute('data-j');
        chair.setAttribute('name', `seats[${i}][${j}][${chairType}]`);
    }
});
