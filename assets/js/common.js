const toggleDetail = (e) => {
  e.currentTarget.classList.toggle("open");
}

const blocks = document.querySelectorAll(`.employee-card`);
blocks.forEach((block) => {
  block.addEventListener('click', (e) => toggleDetail(e))
})