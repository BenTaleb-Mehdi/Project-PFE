export async function askGemini(message, history = []) {
  const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content')

  const response = await fetch('/api/chatbot/send', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
      'Accept': 'application/json',
      'X-CSRF-TOKEN': csrfToken || '',
    },
    body: JSON.stringify({
      chatInput: message,
      history: history,
    }),
  })

  if (!response.ok) {
    const errBody = await response.text().catch(() => '')
    throw new Error(`Server error: ${response.status} - ${errBody}`)
  }

  const data = await response.json()
  return data?.output || 'I had trouble generating a response. Please try again!'
}
