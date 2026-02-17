@extends('layouts.app')

@section('title', $title)
@section('conteudo')




    <div class="container">
        <div class="row blog-post">
            <div class="col-md-5">
                <img src="{{ URL::to('img/1.png') }}" alt="SobreMim" width="100%" height="100%">
            </div>
            <div class="col-md-7 post-content">
                <blockquote>
                    <p style="text-align: justify;">&emsp;&emsp;&emsp;Olá! Meu nome é <strong>[SEU NOME]</strong>, e sou a criadora e mente por trás do "Diário de Uma Modelo". Seja muito bem-vindo(a) ao meu espaço pessoal, onde compartilho um pouco da minha jornada no mundo da moda, beleza e estilo de vida.&nbsp;<br>&emsp;&emsp;&emsp;Minha paixão por moda começou <strong>[COMO COMEÇOU]</strong>. Com o passar dos anos, essa paixão se transformou em uma carreira, e tive a oportunidade de <strong>[EXPERIÊNCIAS]</strong>. Acredito que a excelência e a autenticidade são essenciais para quem deseja trilhar este caminho.<br>&emsp;&emsp;&emsp;Criar o "Diário de Uma Modelo" surgiu do desejo de compartilhar não apenas o glamour que a profissão pode trazer, mas também os desafios, as rotinas de autocuidado, as dicas de beleza que realmente funcionam e as experiências enriquecedoras que vivi e continuo vivendo. Quero que este blog seja um lugar onde você encontre inspiração, informações úteis e uma dose de realidade sobre o universo da moda e como aplicá-lo ao seu dia a dia.&nbsp;<br>&emsp;&emsp;&emsp;Neste espaço, você encontrará dicas de <strong>Moda</strong> (tendências e looks), <strong>Beleza e Autocuidado</strong> (minhas rotinas favoritas) e <strong>Estilo de Vida</strong> (viagens e bastidores). Acredito que a moda é uma forma de expressão e que a beleza vai muito além da aparência. É sobre autoconfiança, bem-estar e autenticidade. Espero que, ao me acompanhar, você se sinta inspirada(o) a explorar seu próprio estilo e a viver sua melhor versão.&nbsp;<br>&emsp;&emsp;&emsp;Obrigada por fazer parte desta jornada! Fique à vontade para explorar o blog e aproveitar todo o conteúdo informativo e educativo que preparamos com muito carinho. Adoraria conhecer você através dos comentários!&nbsp;</p>
<p style="text-align: justify;">Com carinho, <strong>[SEU NOME]</strong>.</p>
                </blockquote>
            </div>
        </div>
    </div>



    </div>

@endsection
