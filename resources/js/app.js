// ── Preloader ────────────────────────────────────────────────────
window.addEventListener('load', () => {
    const preloader = document.getElementById('preloader')
    if (!preloader) return
    preloader.style.opacity = '0'
    setTimeout(() => preloader.remove(), 480)
})

// ── Scroll animations (IntersectionObserver) ─────────────────────
document.addEventListener('DOMContentLoaded', () => {
    const observer = new IntersectionObserver(
        (entries) => {
            entries.forEach((entry) => {
                if (!entry.isIntersecting) return
                const delay = parseInt(entry.target.dataset.delay ?? '0', 10)
                setTimeout(() => entry.target.classList.add('is-visible'), delay)
                observer.unobserve(entry.target)
            })
        },
        { threshold: 0.1, rootMargin: '0px 0px -48px 0px' },
    )

    document.querySelectorAll('[data-animate]').forEach((el) => observer.observe(el))

    // Timeline line draw animation
    const timelineObserver = new IntersectionObserver(
        (entries) => {
            entries.forEach((entry) => {
                if (!entry.isIntersecting) return
                entry.target.classList.add('is-drawn')
                timelineObserver.unobserve(entry.target)
            })
        },
        { threshold: 0.2 },
    )

    document.querySelectorAll('.timeline-line').forEach((el) => timelineObserver.observe(el))
})
