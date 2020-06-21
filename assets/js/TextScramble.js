/**
 * Text Scramble animation class
 *
 * A simple class that provides a text scramble effect when changing between
 * different strings.
 *
 * The original version of this was created by Justin Windle, with minor
 * modifications by William Duyck
 *
 * @author Justin Windle
 * @see {@link https://codepen.io/soulwire/pen/mErPAK}
 */
export default class TextScramble {
  constructor (el) {
    this.el = el
    this.chars = '!<>-_\\/[]{}—=+*^?#&@:;`________'
    this.update = this.update.bind(this)
  }

  setText (newText) {
    const oldText = this.el.innerText
    const length = Math.max(oldText.length, newText.length)
    const promise = new Promise((resolve) => this.resolve = resolve)

    this.queue = []

    for (let i = 0; i < length; i++) {
      const from = oldText[i] || ''
      const to = newText[i] || ''
      const start = Math.floor(Math.random() * 40)
      const end = start + Math.floor(Math.random() * 40)
      this.queue.push({ from, to, start, end })
    }

    cancelAnimationFrame(this.frameRequest)
    this.frame = 0
    this.update()
    return promise
  }

  update () {
    let output = ''
    let complete = 0

    for (let i = 0, j = this.queue.length; i < j; i++) {
      let { from, to, start, end, char } = this.queue[i]

      if (this.frame >= end) {
        complete++
        output += to
      } else if (this.frame >= start) {
        if (!char || Math.random() < 0.28) {
          char = this.getRandomChar()
          this.queue[i].char = char
        }

        output += `<span class="dud">${char}</span>`
      } else {
        output += from
      }
    }

    this.el.innerHTML = output

    if (complete === this.queue.length) {
      this.resolve()
    } else {
      this.frameRequest = requestAnimationFrame(this.update)
      this.frame++
    }
  }

  getRandomChar () {
    return this.chars[Math.floor(Math.random() * this.chars.length)]
  }
}