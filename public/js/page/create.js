//TITLE & SLUG

const titleInput = document.getElementById('title');
const slugInput = document.getElementById('slug');

function generateSlug(title) {
  const slug = title
      .normalize('NFD')
      .replace(/[\u0300-\u036f]/g, '')
      .trim()
      .toLowerCase()
      .replace(/\s+/g, '-')
      .replace(/[^a-z0-9-]/g, '')
      .replace(/--+/g, '-')
      .replace(/^-|-$/g, '');
  return `/${slug}`;
}
  
function updateSlug() {
  const titleValue = titleInput.value;
  const slugValue = generateSlug(titleValue);
  slugInput.value = slugValue;
}

titleInput.addEventListener('input', updateSlug);

updateSlug();