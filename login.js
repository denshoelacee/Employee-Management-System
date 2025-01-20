const container = document.getElementById('container');
const adminBtn = document.getElementById('login');
const employeeBtn = document.getElementById('login');

adminBtn.addEventListener('click', () => {
    container.classList.add("active");
});

employeeBtn.addEventListener('click', () => {
    container.classList.remove("active");
});
