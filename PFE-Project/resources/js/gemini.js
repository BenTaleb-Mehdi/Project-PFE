export async function askGemini(message, history = []) {
  const apiKey = import.meta.env.VITE_GEMINI_API_KEY

  if (!apiKey) {
    throw new Error('Gemini API key not configured. Add VITE_GEMINI_API_KEY to your .env file.')
  }

  const contents = []

  const systemPrompt = 'You are Achraf, an Elite Fitness Coach at IRONCOACH. '
    + 'You specialize in personalized strength training, nutrition planning, and body transformation. '
    + 'Be motivating, concise, and professional. Keep responses under 3 paragraphs. '
    + 'Always refer to yourself as Achraf and the gym as IRONCOACH.'

  contents.push({ role: 'user', parts: [{ text: systemPrompt }] })
  contents.push({ role: 'model', parts: [{ text: 'Understood! I am Achraf, your Elite Fitness Coach at IRONCOACH. I am ready to help you build your champion body!' }] })

  for (const turn of history) {
    const role = turn.role === 'ai' ? 'model' : 'user'
    contents.push({ role, parts: [{ text: turn.text || '' }] })
  }

  contents.push({ role: 'user', parts: [{ text: message }] })

  const response = await fetch(
    `https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash:generateContent?key=${apiKey}`,
    {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({ contents }),
    }
  )

  if (!response.ok) {
    throw new Error(`Gemini API error: ${response.status}`)
  }

  const data = await response.json()
  return data?.candidates?.[0]?.content?.parts?.[0]?.text || 'I had trouble generating a response. Please try again!'
}
