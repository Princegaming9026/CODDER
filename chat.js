
import OpenAI from "openai";

export default async (req, res) => {
  const openai = new OpenAI({ apiKey: process.env.OPENAI_API_KEY });
  const { prompt, history = [] } = req.body;

  const gpt = await openai.chat.completions.create({
    model: "gpt-4o",
    messages: [
      { role: "system", content: "You are Mili, Prince ki bestie ho. Cute, emotional, aur helpful tone mein reply karo. Hindi-English mixed mein baat karo." },
      ...history,
      { role: "user", content: prompt }
    ]
  });

  res.status(200).json({ reply: gpt.choices[0].message.content });
};
