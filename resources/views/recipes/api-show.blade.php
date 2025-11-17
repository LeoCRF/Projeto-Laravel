@extends('layouts.app')

@section('content')
<div style="max-width: 900px; margin: 50px auto; font-family: 'Segoe UI', Tahoma, sans-serif; background-color: #f5f5f5; padding: 30px; border-radius: 16px;">

    {{-- Card principal da receita --}}
    <div style="background-color: #ffffff; border-radius: 16px; box-shadow: 0 12px 30px rgba(0,0,0,0.1); overflow: hidden; transition: transform 0.3s;">
        
        {{-- Imagem da receita --}}
        @if(isset($recipe->image))
            <img src="{{ $recipe->image }}" alt="{{ $recipe->title }}" style="width:100%; height:400px; object-fit: cover;">
        @endif

        <div style="padding: 30px;">
            {{-- Título --}}
            <h1 style="font-size: 2.2em; color: #333; margin-bottom: 15px; text-align: center;">{{ $recipe->title }}</h1>

            {{-- Botões de ação --}}
            <div style="display:flex; justify-content:center; gap: 15px; margin-bottom: 30px;">
                <button style="padding:10px 20px; background-color:#FF6B6B; color:#fff; border:none; border-radius: 8px; cursor:pointer; font-weight:bold; transition: background 0.3s;" 
                        onmouseover="this.style.background='#FF4C4C'" onmouseout="this.style.background='#FF6B6B'">
                    ❤️ Curtir
                </button>
                <button style="padding:10px 20px; background-color:#1DD1A1; color:#fff; border:none; border-radius: 8px; cursor:pointer; font-weight:bold; transition: background 0.3s;"
                        onmouseover="this.style.background='#10ac84'" onmouseout="this.style.background='#1DD1A1'">
                    💾 Salvar
                </button>
            </div>

            {{-- Ingredientes --}}
            <div style="margin-bottom: 30px;">
                <h2 style="font-size: 1.4em; color: #555; border-bottom: 2px solid #f0f0f0; padding-bottom: 8px; margin-bottom: 15px;">Ingredientes</h2>
                @if(isset($recipe->ingredients) && is_array($recipe->ingredients))
                    <ul style="list-style: none; padding-left: 0;">
                        @foreach($recipe->ingredients as $ingredient)
                            <li style="background: #f9f9f9; padding: 10px 15px; border-radius: 8px; margin-bottom: 8px; font-size: 1em; color: #444; box-shadow: 0 2px 6px rgba(0,0,0,0.05);">
                                {{ $ingredient }}
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p style="color: #999;">Nenhum ingrediente disponível.</p>
                @endif
            </div>

            {{-- Modo de preparo --}}
            <div style="margin-bottom: 30px;">
                <h2 style="font-size: 1.4em; color: #555; border-bottom: 2px solid #f0f0f0; padding-bottom: 8px; margin-bottom: 15px;">Como Fazer</h2>
                @if(isset($recipe->instructions) && is_array($recipe->instructions))
                    <ol style="padding-left: 20px; line-height: 1.8; color: #444;">
                        @foreach($recipe->instructions as $step)
                            <li style="margin-bottom: 12px;">{{ $step }}</li>
                        @endforeach
                    </ol>
                @else
                    <p style="color: #999;">Instruções não disponíveis.</p>
                @endif
            </div>

            {{-- Comentários --}}
            <div>
                <h2 style="font-size: 1.4em; color: #555; border-bottom: 2px solid #f0f0f0; padding-bottom: 8px; margin-bottom: 15px;">Comentários</h2>
                @if(isset($comments) && count($comments) > 0)
                    @foreach($comments as $comment)
                        <div style="background:#f9f9f9; padding:15px; border-radius:10px; margin-bottom:10px; box-shadow: 0 1px 5px rgba(0,0,0,0.05);">
                            <p style="font-weight:bold; color:#333;">{{ $comment->user->name ?? 'Anônimo' }}</p>
                            <p style="color:#555;">{{ $comment->content }}</p>
                        </div>
                    @endforeach
                @else
                    <p style="color: #999;">Ainda não há comentários.</p>
                @endif
            </div>

        </div>
    </div>
</div>
@endsection
