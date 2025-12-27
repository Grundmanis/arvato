import { NextResponse } from 'next/server';

export async function POST() {
  const res = await fetch(`${process.env.API_URL}/api/login_check`, {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify({
      username: process.env.API_LOGIN,
      password: process.env.API_PASSWORD,
    }),
  });

  if (!res.ok) {
    return NextResponse.json({ error: 'Auth failed' }, { status: 401 });
  }

  const data = await res.json();

  const response = NextResponse.json({ ok: true });

  response.cookies.set({
    name: 'access_token',
    value: data.token,
    httpOnly: true,
    secure: true,
    sameSite: 'lax',
    path: '/',
  });

  return response;
}
