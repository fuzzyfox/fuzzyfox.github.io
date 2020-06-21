import TextScramble from './TextScramble.js'

const wrappedFetch = (...args) => fetch(...args).then(res => {
  if (!res.ok) {
    const err = new Error(res.statusText)
    err.response = res
    return Promise.reject(err)
  }

  return res.json()
})

document.querySelectorAll('.text-scramble')
  .forEach(el => {
    const delimiter = el.dataset.delimiter || '/'
    const interval = parseInt(el.dataset.interval || 800, 10)
    const phrases = el.textContent.split(delimiter).map(str => str.trim())
    const fx = new TextScramble(el)
    let counter = 0

    el.textContent = ''.padStart(phrases[0].length, '\xa0')

    ;(function next () {
      fx.setText(phrases[counter])
        .then(() => setTimeout(next, interval))
      counter = (counter + 1) % phrases.length
    })()
  })

// Get the currently deployed version and update the version indicator
const repoUrl = 'https://api.github.com/repos/fuzzyfox/fuzzyfox.github.io'
wrappedFetch(`${repoUrl}`)
  .then(repo => Promise.all([
    wrappedFetch(`${repoUrl}/branches/${repo.default_branch}`),
    wrappedFetch(`${repoUrl}/tags`)
  ]))
  .then(([branch, tags]) => {
    const el = document.querySelector('#version a')
    const tag = tags.find(tag => tag.sha === branch.commit.sha)

    if (tag) {
      el.textContent = tag.name
      return
    }

    el.textContent = '#' + branch.commit.sha.slice(0, 7)
  })
  // Failed to get version via github, fallback to package.json
  .catch(() => wrappedFetch('./package.json'))
  .then(pkg => {
    document.querySelector('#version a').textContent = 'v' + pkg.version
  })
  .catch(() => {})