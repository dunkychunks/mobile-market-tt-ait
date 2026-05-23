<div id="smart-advisor-container" style="position: fixed; bottom: 20px; right: 20px; z-index: 1050; font-family: sans-serif;">
    <div id="advisor-bubble" style="display: none; width: 250px; background: white; border-radius: 15px; box-shadow: 0 10px 25px rgba(0,0,0,0.2); margin-bottom: 15px; overflow: hidden; transform: translateY(20px); transition: all 0.3s ease;">
        <div style="background: #ffb524; color: white; padding: 10px 15px; font-weight: bold; font-size: 14px;">
            💡 TT Smart Picks
        </div>
        <div id="advisor-content" style="padding: 10px; max-height: 300px; overflow-y: auto;">
            <div class="text-center py-2"><span class="spinner-border spinner-border-sm text-warning"></span> Loading...</div>
        </div>
    </div>

    <button id="advisor-trigger" style="width: 60px; height: 60px; border-radius: 50%; background: #ffb524; border: none; box-shadow: 0 4px 10px rgba(0,0,0,0.3); color: white; font-size: 24px; cursor: pointer; float: right; transition: transform 0.2s;">
        💡
    </button>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const trigger = document.getElementById('advisor-trigger');
    const bubble = document.getElementById('advisor-bubble');
    const content = document.getElementById('advisor-content');
    let isLoaded = false;

    trigger.addEventListener('click', function() {
        // Toggle visibility
        if (bubble.style.display === 'none') {
            bubble.style.display = 'block';
            setTimeout(() => bubble.style.transform = 'translateY(0)', 10); // smooth slide up
            
            // Fetch via AJAX once per page load. Avoided the exclamation mark here!
            if (isLoaded === false) {
                fetch('/api/smart-suggestions')
                    .then(response => response.json())
                    .then(data => {
                        content.innerHTML = '';
                        data.forEach(item => {
                            content.innerHTML += `
                                <a href="${item.url}" style="display: flex; align-items: center; padding: 8px 0; border-bottom: 1px solid #eee; text-decoration: none; color: #333;">
                                    <img src="${item.image}" style="width: 40px; height: 40px; border-radius: 8px; object-fit: cover; margin-right: 10px;">
                                    <div>
                                        <div style="font-size: 13px; font-weight: bold; line-height: 1.2;">${item.name}</div>
                                        <div style="font-size: 12px; color: #81c408;">$${item.price} TTD</div>
                                    </div>
                                </a>
                            `;
                        });
                        isLoaded = true;
                    })
                    .catch(error => {
                        content.innerHTML = '<div style="font-size:12px; color:red; text-align:center;">Failed to load suggestions.</div>';
                    });
            }
        } else {
            bubble.style.transform = 'translateY(20px)';
            setTimeout(() => bubble.style.display = 'none', 300);
        }
    });
});
</script>
