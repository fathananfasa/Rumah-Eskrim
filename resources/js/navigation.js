// resources/js/navigation.js

document.addEventListener('DOMContentLoaded', () => {
  document.querySelectorAll('button[data-page]').forEach(btn => {
    btn.addEventListener('click', function() {
      const url = this.dataset.page;

      fetch(url, {
        headers: { 'X-Requested-With': 'XMLHttpRequest' }
      })
      .then(res => res.text())
      .then(html => {
        // Ambil konten dari Blade dengan id "content"
        const parser = new DOMParser();
        const doc = parser.parseFromString(html, 'text/html');
        const newContent = doc.querySelector('#content')?.innerHTML || html;

        document.querySelector('#main-content').innerHTML = newContent;
        history.pushState(null, '', url);
      });
    });
  });

  // Tangani back/forward browser
  window.addEventListener('popstate', () => {
    location.reload();
  });
});
