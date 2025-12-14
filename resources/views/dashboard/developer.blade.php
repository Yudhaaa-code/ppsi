<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Developer Dashboard - SIX MONKEY'S</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body style="margin: 0; padding: 0; font-family: system-ui, -apple-system, sans-serif; background-color: #1e3a5f; min-height: 100vh;">
    <!-- Header -->
    <div style="background-color: #1e3a5f; padding: 1.5rem 2rem; display: flex; justify-content: space-between; align-items: center;">
        <div>
            <h1 style="color: white; font-size: 1.5rem; font-weight: bold; text-transform: uppercase; margin: 0;">SIX MONKEY'S</h1>
            <p style="color: rgba(255,255,255,0.8); font-size: 0.875rem; margin: 0.25rem 0 0 0;">BOARD</p>
        </div>
        <div style="display: flex; align-items: center; gap: 1rem;">
            <span style="color: white; font-size: 0.875rem;">{{ Auth::user()->name }}</span>
            <div style="width: 40px; height: 40px; border-radius: 50%; background-color: #4a5568; display: flex; align-items: center; justify-content: center; color: white; font-weight: bold; text-transform: uppercase;">
                {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
            </div>
            <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                @csrf
                <button type="submit" style="background: none; border: 1px solid white; color: white; padding: 0.5rem 1rem; border-radius: 0.25rem; cursor: pointer; font-size: 0.875rem;">Logout</button>
            </form>
        </div>
    </div>

    <!-- Board Container -->
    <div style="padding: 2rem; overflow-x: auto; min-height: calc(100vh - 100px);">
        <div style="display: flex; gap: 1rem; min-width: fit-content;">
            <!-- Today List -->
            <div style="width: 280px; background-color: #fef3c7; border-radius: 0.5rem; padding: 1rem; flex-shrink: 0;">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
                    <h2 style="font-size: 1rem; font-weight: 600; color: #78350f; margin: 0;">Today</h2>
                    <button style="background: none; border: none; cursor: pointer; padding: 0.25rem;">
                        <svg style="width: 1rem; height: 1rem; color: #78350f;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z" />
                        </svg>
                    </button>
                </div>
                <div style="margin-bottom: 0.5rem;">
                    <button style="width: 100%; text-align: left; color: #78350f; font-size: 0.875rem; background: none; border: none; cursor: pointer; padding: 0.5rem;">
                        + Add Card
                    </button>
                </div>
            </div>

            <!-- This Week List -->
            <div style="width: 280px; background-color: #dbeafe; border-radius: 0.5rem; padding: 1rem; flex-shrink: 0;">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
                    <h2 style="font-size: 1rem; font-weight: 600; color: #1e40af; margin: 0;">This Week</h2>
                    <button style="background: none; border: none; cursor: pointer; padding: 0.25rem;">
                        <svg style="width: 1rem; height: 1rem; color: #1e40af;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z" />
                        </svg>
                    </button>
                </div>
                <div style="margin-bottom: 0.5rem;">
                    <button style="width: 100%; text-align: left; color: #1e40af; font-size: 0.875rem; background: none; border: none; cursor: pointer; padding: 0.5rem;">
                        + Add Card
                    </button>
                </div>
            </div>

            <!-- Later List -->
            <div style="width: 280px; background-color: #fce7f3; border-radius: 0.5rem; padding: 1rem; flex-shrink: 0;">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
                    <h2 style="font-size: 1rem; font-weight: 600; color: #9f1239; margin: 0;">Later</h2>
                    <button style="background: none; border: none; cursor: pointer; padding: 0.25rem;">
                        <svg style="width: 1rem; height: 1rem; color: #9f1239;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z" />
                        </svg>
                    </button>
                </div>
                <div style="margin-bottom: 0.5rem;">
                    <button style="width: 100%; text-align: left; color: #9f1239; font-size: 0.875rem; background: none; border: none; cursor: pointer; padding: 0.5rem;">
                        + Add Card
                    </button>
                </div>
            </div>

            <!-- Add Another List Button -->
            <div style="width: 280px; flex-shrink: 0;">
                <button style="width: 100%; background-color: #86efac; border: none; border-radius: 0.5rem; padding: 1rem; color: #065f46; font-size: 0.875rem; font-weight: 600; cursor: pointer; text-align: left;">
                    + Add Another List
                </button>
            </div>
        </div>
    </div>
</body>
</html>
