import { cookies } from 'next/headers';
import { NextResponse } from 'next/server';

export async function GET(_request: Request, context: { params: Promise<{ id: string }> }) {
  const params = await context.params;
  const id = params.id;
  try {
    const cookieStore = await cookies();
    const token = cookieStore.get('access_token')?.value;

    if (!token) {
      return NextResponse.json({ error: 'Unauthorized' }, { status: 401 });
    }

    const url = `${process.env.API_URL}/api/products/${id}`;

    const res = await fetch(url, {
      headers: {
        Authorization: `Bearer ${token}`,
      },
    });

    const body = await res.text();

    return new NextResponse(body, {
      status: res.status,
      headers: { 'Content-Type': 'application/json' },
    });
  } catch (e) {
    console.error('[API] product by id error', e);
    return NextResponse.json({ error: 'Internal server error' }, { status: 500 });
  }
}
