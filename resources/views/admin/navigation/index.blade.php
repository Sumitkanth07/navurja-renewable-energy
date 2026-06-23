@extends('layouts.admin')
@section('content')
<div class="topbar">
    <h1>Navigation Manager</h1>
    <a class="button" href="{{ route('admin.navigation.create') }}">Add Navigation Item</a>
</div>

@php
    $headerItems = $items->where('menu_position', 'header');
    $footerItems = $items->where('menu_position', 'footer');
@endphp

<div class="panel" style="margin-bottom: 30px;">
    <h2 style="margin-top: 0; color: #78d873; border-bottom: 2px solid #223b2c; padding-bottom: 10px;">Header Menu Manager</h2>
    @if($headerItems->isEmpty())
        <p style="color: #95aa9d;">No header menu items found.</p>
    @else
        <table style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr style="border-bottom: 2px solid #223b2c;">
                    <th>Label</th>
                    <th>URL / Link</th>
                    <th>Parent Item</th>
                    <th>Sort Order</th>
                    <th>Status</th>
                    <th style="text-align: right;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($headerItems as $item)
                <tr style="border-bottom: 1px solid #1a2f24;">
                    <td style="font-weight: bold; color: #eef8f1;">{{ $item->label }}</td>
                    <td style="color: #95aa9d; font-family: monospace;">{{ $item->url }}</td>
                    <td>{{ optional($item->parent)->label ?? 'None (Top Level)' }}</td>
                    <td>{{ $item->sort_order }}</td>
                    <td>
                        @if($item->is_active)
                            <span style="background: #163e27; color: #bcf5cc; padding: 4px 8px; border-radius: 4px; font-size: 0.85rem; font-weight: bold;">Active</span>
                        @else
                            <span style="background: #4a1717; color: #ffd9d9; padding: 4px 8px; border-radius: 4px; font-size: 0.85rem; font-weight: bold;">Disabled</span>
                        @endif
                    </td>
                    <td style="text-align: right;">
                        <a href="{{ route('admin.navigation.edit', $item) }}" style="color: #78d873; margin-right: 15px; text-decoration: underline;">Edit</a>
                        <form method="post" action="{{ route('admin.navigation.destroy', $item) }}" style="display:inline;">
                            @csrf
                            @method('delete')
                            <button onclick="return confirm('Are you sure you want to delete this navigation item?')" style="background:none; border:none; color:red; cursor:pointer; text-decoration:underline; font-weight:bold;">Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>

<div class="panel">
    <h2 style="margin-top: 0; color: #78d873; border-bottom: 2px solid #223b2c; padding-bottom: 10px;">Footer Menu Manager</h2>
    @if($footerItems->isEmpty())
        <p style="color: #95aa9d;">No footer menu items found.</p>
    @else
        <table style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr style="border-bottom: 2px solid #223b2c;">
                    <th>Label</th>
                    <th>URL / Link</th>
                    <th>Sort Order</th>
                    <th>Status</th>
                    <th style="text-align: right;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($footerItems as $item)
                <tr style="border-bottom: 1px solid #1a2f24;">
                    <td style="font-weight: bold; color: #eef8f1;">{{ $item->label }}</td>
                    <td style="color: #95aa9d; font-family: monospace;">{{ $item->url }}</td>
                    <td>{{ $item->sort_order }}</td>
                    <td>
                        @if($item->is_active)
                            <span style="background: #163e27; color: #bcf5cc; padding: 4px 8px; border-radius: 4px; font-size: 0.85rem; font-weight: bold;">Active</span>
                        @else
                            <span style="background: #4a1717; color: #ffd9d9; padding: 4px 8px; border-radius: 4px; font-size: 0.85rem; font-weight: bold;">Disabled</span>
                        @endif
                    </td>
                    <td style="text-align: right;">
                        <a href="{{ route('admin.navigation.edit', $item) }}" style="color: #78d873; margin-right: 15px; text-decoration: underline;">Edit</a>
                        <form method="post" action="{{ route('admin.navigation.destroy', $item) }}" style="display:inline;">
                            @csrf
                            @method('delete')
                            <button onclick="return confirm('Are you sure you want to delete this navigation item?')" style="background:none; border:none; color:red; cursor:pointer; text-decoration:underline; font-weight:bold;">Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
