/**
 * InduziGuidePresets — Sugestoes e templates para componentes guided
 * Cada campo recebe: suggestions (chips clicaveis) + templates (conjuntos prontos)
 */
var InduziGuidePresets = {

copywriter: {
    'puv.produto': {
        suggestions: ['Curso online', 'Software SaaS', 'Consultoria', 'E-book digital', 'App mobile', 'Plataforma web', 'Assinatura', 'Produto fisico'],
        templates: [
            { label: 'Estrutura de PUV', items: ['Nome do produto e categoria', 'Problema principal que resolve', 'Resultado especifico que entrega', 'Prazo ou rapidez da solucao', 'Garantia ou diferencial competitivo'] }
        ]
    },
    'puv.publico': {
        suggestions: ['Empreendedores digitais', 'Profissionais de marketing', 'Gestores de e-commerce', 'Desenvolvedores web', 'Criadores de conteudo', 'Pequenas empresas', 'Freelancers'],
        templates: [
            { label: 'Definicao de publico', items: ['Segmento ou nicho de mercado', 'Nivel de experiencia', 'Principal desafio enfrentado', 'Objetivo ou meta desejada'] }
        ]
    },
    'puv.diferencial': {
        suggestions: ['Tecnologia exclusiva', 'Metodologia propria', 'Suporte personalizado', 'Preco competitivo', 'Entrega mais rapida', 'Garantia estendida', 'Comunidade ativa'],
        templates: [
            { label: 'Comparacao competitiva', items: ['O que concorrentes oferecem', 'O que voce oferece de unico', 'Beneficio tangivel da diferenca', 'Prova ou validacao do diferencial'] }
        ]
    },
    'puv.transformacao': {
        suggestions: ['Economia de tempo', 'Aumento de receita', 'Reducao de custos', 'Ganho de produtividade', 'Melhoria de qualidade', 'Crescimento escalavel'],
        templates: [
            { label: 'Antes e depois', items: ['Situacao atual (dor/problema)', 'Situacao desejada (resultado)', 'Transformacao mensuravel', 'Prazo estimado para mudanca'] }
        ]
    },
    'puv.frase': {
        suggestions: ['Formula [Resultado] em [Prazo]', 'Formula [Beneficio] sem [Objecao]', 'Formula [Transformacao] para [Publico]'],
        templates: [
            { label: 'Estruturas de PUV', items: ['[Produto] que ajuda [Publico] a [Resultado] atraves de [Diferencial]', 'A unica [Categoria] que [Beneficio Unico] sem [Objecao Comum]', '[Resultado Especifico] em [Prazo] ou [Garantia]'] }
        ]
    },
    'persona.nome': {
        suggestions: ['Ana Empreendedora', 'Carlos Gestor', 'Juliana Freelancer', 'Pedro Desenvolvedor', 'Mariana Criadora'],
        templates: [
            { label: 'Identificacao da persona', items: ['Nome ficticio representativo', 'Idade aproximada', 'Cargo ou funcao principal', 'Resumo de perfil (1 frase)'] }
        ]
    },
    'persona.demografico': {
        suggestions: ['25-35 anos', '35-45 anos', 'Ensino superior completo', 'Renda media-alta', 'Urbano, grandes centros', 'Classe B/C'],
        templates: [
            { label: 'Dados demograficos', items: ['Faixa etaria', 'Genero predominante', 'Escolaridade', 'Faixa de renda mensal', 'Localizacao geografica'] }
        ]
    },
    'persona.profissao': {
        suggestions: ['Gerente de marketing', 'Desenvolvedor full-stack', 'Designer freelancer', 'Analista de SEO', 'E-commerce manager', 'Consultor de negocios'],
        templates: [
            { label: 'Contexto profissional', items: ['Cargo ou funcao atual', 'Setor de atuacao', 'Tamanho da empresa', 'Principais responsabilidades', 'Ferramentas que usa diariamente'] }
        ]
    },
    'persona.dores': {
        suggestions: ['Falta de tempo', 'Orcamento limitado', 'Falta de conhecimento tecnico', 'Dificuldade em escalar', 'Muitas tarefas manuais', 'Resultados inconsistentes'],
        templates: [
            { label: 'Mapeamento de dores', items: ['Maior desafio no dia a dia', 'Frustracao recorrente', 'Medo ou inseguranca principal', 'O que tira o sono', 'Tentativas anteriores que falharam'] }
        ]
    },
    'persona.desejos': {
        suggestions: ['Aumentar vendas', 'Automatizar processos', 'Ganhar autoridade', 'Ter mais tempo livre', 'Crescer negocio', 'Melhorar performance'],
        templates: [
            { label: 'Objetivos e aspiracoes', items: ['Meta profissional principal', 'Resultado que gostaria de alcancar', 'Como gostaria de ser reconhecido', 'Indicador de sucesso pessoal'] }
        ]
    },
    'persona.objecoes': {
        suggestions: ['Preco muito alto', 'Nao tenho tempo agora', 'Preciso de aprovacao', 'Nao confio em promessas', 'Ja tentei antes', 'Complexo demais'],
        templates: [
            { label: 'Objecoes e contrapontos', items: ['Objecao: [motivo]', 'Contraponto: [argumento]', 'Prova: [evidencia ou garantia]', 'CTA: [proximo passo]'] }
        ]
    },
    'voz.descricao': {
        suggestions: ['Profissional e acessivel', 'Descontraida e humana', 'Tecnica e precisa', 'Inspiradora e motivacional', 'Direta e objetiva', 'Educativa e empatica'],
        templates: [
            { label: 'Definicao de tom', items: ['Personalidade da marca (3-4 adjetivos)', 'Nivel de formalidade (1-10)', 'Como queremos ser percebidos', 'Emocao principal que transmitimos'] }
        ]
    },
    'voz.usar': {
        suggestions: ['Linguagem clara', 'Exemplos praticos', 'Perguntas abertas', 'Storytelling', 'Dados e metricas', 'Verbos de acao'],
        templates: [
            { label: 'Elementos a utilizar', items: ['Palavras e expressoes caracteristicas', 'Formatos de conteudo preferidos', 'Tipo de humor (se aplicavel)', 'Uso de jargoes tecnicos (quando)'] }
        ]
    },
    'voz.evitar': {
        suggestions: ['Jargoes excessivos', 'Linguagem rebuscada', 'Tom condescendente', 'Promessas vazias', 'Negatividade', 'Girias datadas'],
        templates: [
            { label: 'Elementos a evitar', items: ['Palavras e expressoes proibidas', 'Tom de voz inadequado', 'Temas ou assuntos sensiveis', 'Erros comuns de comunicacao'] }
        ]
    },
    'voz.exemplo': {
        suggestions: ['Post em redes sociais', 'E-mail de boas-vindas', 'Pagina de vendas', 'Resposta a objecao', 'Anuncio publicitario'],
        templates: [
            { label: 'Exemplo aplicado', items: ['Contexto: [onde sera usado]', 'Texto de exemplo: [2-3 linhas]', 'Por que funciona: [justificativa]'] }
        ]
    },
    'headlines.principal': {
        suggestions: ['Beneficio claro', 'Resultado em prazo', 'Solucao para dor', 'Curiosidade provocativa', 'Transformacao especifica'],
        templates: [
            { label: 'Estruturas de headline', items: ['Como [Publico] pode [Resultado] em [Prazo]', 'A forma mais [Adjetivo] de [Acao] sem [Objecao]', '[Numero] maneiras de [Beneficio]', 'Descubra o segredo para [Resultado Desejado]'] }
        ]
    },
    'headlines.sub': {
        suggestions: ['Detalhe do beneficio', 'Prova social', 'Garantia oferecida', 'Diferencial unico', 'Urgencia sutil'],
        templates: [
            { label: 'Subheadlines de suporte', items: ['Expanda o beneficio da headline', 'Adicione prova social ou numero', 'Remova objecao principal', 'Crie curiosidade para continuar lendo'] }
        ]
    },
    'headlines.alternativas': {
        suggestions: ['Versao curiosidade', 'Versao beneficio direto', 'Versao social proof', 'Versao urgencia', 'Versao emocional'],
        templates: [
            { label: 'Variacoes para teste A/B', items: ['Versao 1: foco em beneficio', 'Versao 2: foco em dor', 'Versao 3: foco em prova social', 'Versao 4: foco em curiosidade'] }
        ]
    },
    'headlines.formulas': {
        suggestions: ['Formula 4U', 'PAS (Problema-Agitar-Solucao)', 'AIDA', 'Before-After-Bridge', 'Curiosity Gap'],
        templates: [
            { label: 'Formulas classicas', items: ['Como [Acao] sem [Objecao]', 'O segredo de [Autoridade] para [Resultado]', '[Numero] formas de [Beneficio] comprovadas', 'Voce esta cometendo estes [Numero] erros?'] }
        ]
    },
    'landing.hero': {
        suggestions: ['Headline impactante', 'Subheadline clara', 'CTA primario visivel', 'Imagem de impacto', 'Prova social acima da dobra'],
        templates: [
            { label: 'Secao hero', items: ['Headline principal (promessa ou beneficio)', 'Subheadline (detalhe ou prova)', 'CTA primario claro e contrastante', 'Visual representativo do resultado', 'Elemento de confianca (selo, depoimento)'] }
        ]
    },
    'landing.beneficios': {
        suggestions: ['Lista com icones', 'Comparacao antes/depois', 'Features vs beneficios', 'Beneficios numerados', 'Transformacao em etapas'],
        templates: [
            { label: 'Secao de beneficios', items: ['Beneficio 1: [titulo] - [descricao curta]', 'Beneficio 2: [titulo] - [descricao curta]', 'Beneficio 3: [titulo] - [descricao curta]', 'Resultado final esperado'] }
        ]
    },
    'landing.prova_social': {
        suggestions: ['Depoimentos em video', 'Cases com numeros', 'Logos de clientes', 'Avaliacoes e estrelas', 'Mencoes na midia'],
        templates: [
            { label: 'Elementos de prova social', items: ['Depoimento: "[citacao]" - Nome, Cargo', 'Metrica de impacto: X clientes/resultados', 'Selos de confianca ou certificacoes', 'Case de sucesso detalhado'] }
        ]
    },
    'landing.cta': {
        suggestions: ['Comecar agora', 'Fazer teste gratis', 'Agendar demonstracao', 'Baixar material', 'Garantir desconto', 'Falar com especialista'],
        templates: [
            { label: 'Estrutura de CTA', items: ['Texto do botao (verbo de acao + beneficio)', 'Microcopy abaixo (remocao de risco)', 'Cor e tamanho destacados', 'Repetir em 2-3 pontos da pagina'] }
        ]
    },
    'landing.urgencia': {
        suggestions: ['Vagas limitadas', 'Oferta por tempo limitado', 'Bonus exclusivos', 'Desconto progressivo', 'Contador regressivo'],
        templates: [
            { label: 'Gatilhos de urgencia', items: ['Elemento de escassez: [vagas, unidades, tempo]', 'Prazo especifico ou contador', 'Bonus que expiram', 'Consequencia de nao agir agora'] }
        ]
    },
    'email.assunto': {
        suggestions: ['Curiosidade aberta', 'Beneficio direto', 'Personalizacao', 'Pergunta provocativa', 'Urgencia sutil', 'Numero ou lista'],
        templates: [
            { label: 'Formulas de assunto', items: ['[Nome], voce viu isso?', 'Como [Beneficio] em [Prazo]', '[Numero] segredos sobre [Tema]', 'Ultima chance: [Oferta]'] }
        ]
    },
    'email.corpo': {
        suggestions: ['Saudacao pessoal', 'Hook inicial', 'Beneficio claro', 'Storytelling breve', 'CTA unico', 'P.S. estrategico'],
        templates: [
            { label: 'Estrutura de e-mail', items: ['Saudacao: Ola [Nome],', 'Hook: frase que conecta ao assunto', 'Corpo: problema -> solucao -> beneficio', 'CTA: um unico pedido claro', 'P.S.: reforco de urgencia ou beneficio extra'] }
        ]
    },
    'email.sequencia': {
        suggestions: ['Boas-vindas', 'Educacao de valor', 'Case de sucesso', 'Superacao de objecao', 'Oferta direta', 'Ultima chance'],
        templates: [
            { label: 'Sequencia de e-mails', items: ['Email 1 (D+0): Boas-vindas e entrega do prometido', 'Email 2 (D+2): Valor educativo relacionado', 'Email 3 (D+4): Case de sucesso ou prova social', 'Email 4 (D+6): Resposta a objecao comum', 'Email 5 (D+8): Oferta com urgencia'] }
        ]
    },
    'email.templates': {
        suggestions: ['Boas-vindas', 'Carrinho abandonado', 'Reengajamento', 'Lancamento', 'Newsletter', 'Transacional'],
        templates: [
            { label: 'Template de boas-vindas', items: ['Assunto: Bem-vindo(a)! Aqui esta [Promessa]', 'Cumprimento caloroso e pessoal', 'Entrega imediata do lead magnet', 'Proximos passos claros'] }
        ]
    },
    'redes.bio': {
        suggestions: ['O que voce faz', 'Para quem ajuda', 'Resultado que entrega', 'CTA claro', 'Link na bio'],
        templates: [
            { label: 'Estrutura de bio', items: ['[Cargo/Funcao]', 'Ajudo [Publico] a [Resultado]', '[Diferencial ou Prova Social]', 'CTA: [Acao desejada] + [Link]'] }
        ]
    },
    'redes.hashtags': {
        suggestions: ['5-10 hashtags', 'Mix popular e nicho', 'Hashtag de marca', 'Geolocalizacao', 'Hashtags sazonais'],
        templates: [
            { label: 'Estrategia de hashtags', items: ['2-3 hashtags populares (100k+ posts)', '3-5 hashtags medias (10k-100k)', '2-3 hashtags de nicho (<10k)', '1 hashtag de marca propria'] }
        ]
    },
    'redes.frequencia': {
        suggestions: ['Instagram: 3-5x/semana', 'LinkedIn: 2-3x/semana', 'Twitter: 1-3x/dia', 'TikTok: 1-2x/dia'],
        templates: [
            { label: 'Calendario semanal', items: ['Segunda: [tipo de conteudo]', 'Quarta: [tipo de conteudo]', 'Sexta: [tipo de conteudo]', 'Stories: diariamente'] }
        ]
    },
    'storytelling.marca': {
        suggestions: ['Origem da empresa', 'Por que comecamos', 'Missao e valores', 'Desafios superados', 'Evolucao e marcos'],
        templates: [
            { label: 'Historia da marca', items: ['Como tudo comecou (origem)', 'Problema que motivou a criacao', 'Momento de virada ou insight', 'Valores que guiam a jornada', 'Onde estamos hoje e para onde vamos'] }
        ]
    },
    'storytelling.jornada': {
        suggestions: ['Jornada do heroi', 'Antes e depois', 'Desafio e superacao', 'Transformacao pessoal', 'Descoberta'],
        templates: [
            { label: 'Jornada do cliente', items: ['Situacao inicial (status quo)', 'Problema ou chamado para mudanca', 'Encontro com a solucao', 'Desafios e resistencia', 'Transformacao e novo estado'] }
        ]
    },
    'storytelling.casos': {
        suggestions: ['Cliente transformado', 'Desafio complexo resolvido', 'Resultado inesperado', 'Processo de implementacao'],
        templates: [
            { label: 'Case de sucesso', items: ['Cliente: [nome ou perfil]', 'Desafio: [problema especifico]', 'Solucao: [abordagem usada]', 'Resultado: [metricas e impacto]'] }
        ]
    },
    'cta.principal': {
        suggestions: ['Compre agora', 'Comece gratis', 'Agende demonstracao', 'Baixe o guia', 'Fale com vendas', 'Inscreva-se hoje'],
        templates: [
            { label: 'CTA de alta conversao', items: ['Verbo de acao + beneficio imediato', 'Cor contrastante e botao grande', 'Remocao de risco abaixo do botao', 'Repetir em pontos estrategicos'] }
        ]
    },
    'cta.secundarios': {
        suggestions: ['Saiba mais', 'Ver demonstracao', 'Ler case', 'Falar com especialista', 'Baixar material', 'Assistir video'],
        templates: [
            { label: 'CTAs de menor compromisso', items: ['CTA educativo (ler, assistir, baixar)', 'CTA de contato (falar, agendar)', 'CTA social (seguir, compartilhar)', 'CTA de exploracao (ver mais, descobrir)'] }
        ]
    },
    'cta.gatilhos': {
        suggestions: ['Urgencia temporal', 'Escassez de vagas', 'Prova social', 'Garantia de risco zero', 'Bonus exclusivos'],
        templates: [
            { label: 'Gatilhos mentais no CTA', items: ['Urgencia: "Apenas ate [data]"', 'Escassez: "Restam X vagas"', 'Autoridade: "Usado por X empresas"', 'Seguranca: "Garantia de 30 dias"'] }
        ]
    },
    'cta.garantias': {
        suggestions: ['30 dias dinheiro de volta', 'Satisfacao garantida', 'Suporte ilimitado', 'Sem risco, cancele quando quiser', 'Teste gratis sem cartao'],
        templates: [
            { label: 'Remocao de risco', items: ['Tipo de garantia oferecida', 'Prazo da garantia', 'Processo de acionamento', 'Posicionamento visual proximo ao CTA'] }
        ]
    }
},

seo: {
    'palavras.principais': {
        suggestions: ['Google Keyword Planner', 'Analise de concorrentes', 'Google Trends', 'Semrush ou Ahrefs', 'Search Console'],
        templates: [
            { label: 'Pesquisa de palavras-chave', items: ['Palavra-chave 1: [termo] - [volume] - [dificuldade]', 'Palavra-chave 2: [termo] - [volume] - [dificuldade]', 'Intencao de busca: [informacional/transacional]', 'Prioridade de otimizacao'] }
        ]
    },
    'palavras.secundarias': {
        suggestions: ['Variacoes semanticas', 'Sinonimos', 'Termos relacionados', 'People Also Ask', 'LSI keywords'],
        templates: [
            { label: 'Palavras secundarias', items: ['Grupo tematico: [tema principal]', 'Variacao 1: [termo relacionado]', 'Variacao 2: [termo relacionado]', 'Contexto de uso no conteudo'] }
        ]
    },
    'palavras.long_tail': {
        suggestions: ['Perguntas frequentes', 'Combinacoes 3+ palavras', 'Buscas conversacionais', 'Problemas especificos', 'Comparacoes'],
        templates: [
            { label: 'Long-tail keywords', items: ['Como [acao] [contexto especifico]', 'Melhor [produto/servico] para [situacao]', '[Produto A] vs [Produto B]', 'Por que [problema] acontece'] }
        ]
    },
    'palavras.concorrentes': {
        suggestions: ['Analise de rankings', 'Gap de palavras-chave', 'Paginas top deles', 'Trafego estimado', 'Dificuldade de superar'],
        templates: [
            { label: 'Analise de concorrentes', items: ['Concorrente: [dominio]', 'Palavras-chave que rankeia', 'Posicao media: [ranking]', 'Oportunidades identificadas'] }
        ]
    },
    'onpage.headings': {
        suggestions: ['H1 unico por pagina', 'H2 para secoes principais', 'H3 para subssecoes', 'Palavras-chave em headings', 'Hierarquia logica'],
        templates: [
            { label: 'Estrutura de headings', items: ['H1: [titulo principal com palavra-chave]', 'H2: [secao 1]', 'H3: [subssecao 1.1]', 'Palavra-chave principal no H1 e em 2-3 H2s'] }
        ]
    },
    'onpage.urls': {
        suggestions: ['Curtas e descritivas', 'Com palavra-chave', 'Hifens nao underscores', 'Minusculas', 'Sem parametros desnecessarios'],
        templates: [
            { label: 'Padrao de URLs', items: ['Estrutura: dominio.com/categoria/palavra-chave', 'Maximo 3-5 palavras', 'Evitar: numeros, datas, IDs', 'Permanentes (evitar mudancas)'] }
        ]
    },
    'onpage.internal_links': {
        suggestions: ['Link para conteudo relacionado', 'Anchor text descritivo', 'Links contextuais', 'Hierarquia de paginas'],
        templates: [
            { label: 'Links internos', items: ['Paginas pilares linkam para cluster de conteudos', '3-5 links internos por pagina', 'Anchor text com variacao semantica', 'Atualizar links em conteudos antigos'] }
        ]
    },
    'conteudo.estrategia': {
        suggestions: ['Conteudo pilar e cluster', 'Calendario editorial', 'Mix de formatos', 'Atualizacao de antigos', 'Foco em intencao de busca'],
        templates: [
            { label: 'Estrategia de conteudo SEO', items: ['Tema pilar 1: [topico amplo]', 'Cluster de artigos relacionados (5-10 posts)', 'Frequencia de publicacao: [X por semana]', 'Metas de trafego organico'] }
        ]
    },
    'conteudo.calendario': {
        suggestions: ['Mensal por temas', 'Sazonal e tendencias', 'Atualizacao de top posts', 'Conteudo evergreen', 'Lancamentos'],
        templates: [
            { label: 'Calendario editorial', items: ['Semana 1: [tema/palavra-chave]', 'Semana 2: [tema/palavra-chave]', 'Semana 3: [tema/palavra-chave]', 'Semana 4: [atualizacao de conteudo antigo]'] }
        ]
    },
    'conteudo.guidelines': {
        suggestions: ['Minimo de palavras', 'Tom de voz', 'Estrutura padrao', 'Uso de imagens', 'Meta descriptions'],
        templates: [
            { label: 'Diretrizes de conteudo', items: ['Extensao minima: 800-1500+ palavras', 'Incluir: introducao, subtitulos H2/H3, conclusao', 'Palavra-chave: 1-2% de densidade', 'Meta description: 150-160 caracteres'] }
        ]
    },
    'tecnico.sitemap': {
        suggestions: ['XML atualizado', 'Enviar ao Search Console', 'Paginas prioritarias', 'Exclusao de duplicadas'],
        templates: [
            { label: 'Configuracao de sitemap', items: ['Gerar sitemap.xml automaticamente', 'Incluir apenas paginas indexaveis', 'Enviar ao Google Search Console', 'Adicionar sitemap no robots.txt'] }
        ]
    },
    'tecnico.robots': {
        suggestions: ['Bloquear admin e duplicatas', 'Permitir rastreamento', 'Sitemap no robots.txt', 'User-agent especificos'],
        templates: [
            { label: 'Arquivo robots.txt', items: ['User-agent: *', 'Disallow: /admin/', 'Allow: /', 'Sitemap: https://dominio.com/sitemap.xml'] }
        ]
    },
    'tecnico.schema': {
        suggestions: ['Organization', 'Article', 'Product', 'Breadcrumb', 'FAQ', 'Review', 'LocalBusiness'],
        templates: [
            { label: 'Schema markup', items: ['Schema Organization (dados da empresa)', 'Schema Article (posts do blog)', 'Schema Breadcrumb (navegacao)', 'Schema FAQ (se aplicavel)', 'Validar com Google Rich Results Test'] }
        ]
    },
    'tecnico.canonical': {
        suggestions: ['Evitar duplicacao', 'URL preferencial', 'Cross-domain', 'Paginacao', 'Parametros de URL'],
        templates: [
            { label: 'Canonical tags', items: ['Cada pagina aponta para si mesma', 'Versoes duplicadas apontam para a original', 'URLs com parametros apontam para a limpa', 'Verificar canonical em todas as paginas'] }
        ]
    },
    'tecnico.indexacao': {
        suggestions: ['Index vs noindex', 'Paginas orfas', 'Crawl budget', 'Paginas bloqueadas', 'Erros de rastreamento'],
        templates: [
            { label: 'Gestao de indexacao', items: ['Indexar: paginas de conteudo e conversao', 'Noindex: admin, filtros, duplicatas', 'Verificar cobertura no Search Console', 'Corrigir erros de rastreamento'] }
        ]
    },
    'links.estrategia': {
        suggestions: ['Guest posts', 'Parcerias', 'Link building ativo', 'Conteudo linkavel', 'Digital PR'],
        templates: [
            { label: 'Link building', items: ['Guest posts em blogs relevantes (2-4/mes)', 'Criar conteudo linkavel (infograficos, estudos)', 'Parcerias e co-marketing', 'Recuperar mencoes sem link'] }
        ]
    },
    'links.guest_posts': {
        suggestions: ['Identificar sites relevantes', 'Pitch personalizado', 'Conteudo original', 'Link contextual', 'Relacionamento continuo'],
        templates: [
            { label: 'Processo de guest post', items: ['Listar 10-20 sites do nicho (DR 30+)', 'Analisar conteudo aceito por eles', 'Criar pitch personalizado', 'Escrever artigo original (1000+ palavras)'] }
        ]
    },
    'local.gmb': {
        suggestions: ['Perfil completo', 'Fotos atualizadas', 'Posts semanais', 'Respostas a avaliacoes', 'Horarios corretos'],
        templates: [
            { label: 'Google Meu Negocio', items: ['Preencher 100% do perfil', 'Adicionar 10+ fotos de qualidade', 'Publicar posts 1-2x/semana', 'Responder todas as avaliacoes em 24h'] }
        ]
    },
    'local.avaliacoes': {
        suggestions: ['Solicitar avaliacoes', 'Responder todas', 'Diversificar plataformas', 'Incentivar positivas', 'Resolver negativas'],
        templates: [
            { label: 'Gestao de avaliacoes', items: ['Solicitar avaliacao apos cada venda', 'Responder 100% das avaliacoes', 'Tom profissional e empatico', 'Meta: manter 4.5+ estrelas'] }
        ]
    },
    'local.citacoes': {
        suggestions: ['NAP consistente', 'Diretorios locais', 'Redes sociais', 'Sites de nicho', 'Verificar duplicatas'],
        templates: [
            { label: 'Citacoes locais', items: ['Nome, Endereco, Telefone identicos em todos os lugares', 'Listar em: Google, Bing, Facebook', 'Diretorios locais e de nicho', 'Verificar e corrigir duplicatas'] }
        ]
    },
    'performance.otimizacoes': {
        suggestions: ['Core Web Vitals', 'PageSpeed Insights', 'Compressao de imagens', 'Cache', 'CDN', 'Minificacao'],
        templates: [
            { label: 'Checklist de performance', items: ['LCP < 2.5s', 'FID < 100ms', 'CLS < 0.1', 'Comprimir imagens (WebP, lazy load)', 'Minificar CSS/JS', 'Usar CDN e cache'] }
        ]
    },
    'mobile.responsividade': {
        suggestions: ['Design mobile-first', 'Viewport configurado', 'Fontes legiveis', 'Botoes clicaveis', 'Imagens adaptativas'],
        templates: [
            { label: 'Checklist mobile', items: ['Meta viewport configurado', 'Design responsivo', 'Fontes minimo 16px', 'Botoes minimo 48x48px', 'Testar em dispositivos reais'] }
        ]
    },
    'mobile.ux_mobile': {
        suggestions: ['Navegacao simplificada', 'Menu hamburger', 'Forms curtos', 'CTA destacado', 'Scroll vertical'],
        templates: [
            { label: 'UX mobile', items: ['Menu hamburger ou tab bar', 'CTAs fixos ou sticky', 'Formularios com poucos campos', 'Autocomplete e teclados contextuais'] }
        ]
    },
    'mobile.testes': {
        suggestions: ['Google Mobile-Friendly Test', 'Testar em diferentes devices', 'Emuladores', 'Velocidade mobile'],
        templates: [
            { label: 'Testes mobile', items: ['Google Mobile-Friendly Test', 'PageSpeed Insights (mobile)', 'Testar em iOS e Android', 'Verificar usabilidade no Search Console'] }
        ]
    },
    'imagens.alt_text': {
        suggestions: ['Descritivo e conciso', 'Palavra-chave quando natural', 'Contexto da imagem', 'Evitar "imagem de"'],
        templates: [
            { label: 'Alt text otimizado', items: ['Descrever o conteudo da imagem (5-15 palavras)', 'Incluir palavra-chave se relevante', 'Imagens decorativas: alt vazio alt=""'] }
        ]
    },
    'imagens.lazy_loading': {
        suggestions: ['Loading="lazy"', 'Priorizar above-the-fold', 'Placeholder ou blur', 'Bibliotecas JS'],
        templates: [
            { label: 'Lazy loading', items: ['Atributo loading="lazy" em img', 'Carregar imagens above-the-fold normalmente', 'Usar placeholders (blur-up)', 'Testar impacto no LCP'] }
        ]
    },
    'imagens.nomeacao': {
        suggestions: ['Nomes descritivos', 'Palavras-chave', 'Hifens entre palavras', 'Minusculas'],
        templates: [
            { label: 'Convencao de nomenclatura', items: ['palavra-chave-descricao.jpg', 'Usar hifens, nao underscores', 'Tudo em minusculas', 'Evitar: IMG_1234.jpg'] }
        ]
    },
    'analytics.ga4': {
        suggestions: ['Eventos personalizados', 'Conversoes', 'Funis', 'Segmentos', 'Relatorios customizados'],
        templates: [
            { label: 'Configuracao GA4', items: ['Instalar tag GA4 + GTM', 'Configurar eventos de conversao', 'Criar funis de conversao', 'Conectar com Search Console'] }
        ]
    },
    'analytics.search_console': {
        suggestions: ['Verificar propriedade', 'Enviar sitemap', 'Monitorar cobertura', 'Analise de consultas'],
        templates: [
            { label: 'Search Console', items: ['Verificar propriedade do site', 'Enviar sitemap.xml', 'Monitorar indice e cobertura', 'Analisar principais consultas e paginas'] }
        ]
    },
    'analytics.relatorios': {
        suggestions: ['Relatorio mensal', 'Trafego organico', 'Rankings', 'Conversoes', 'Backlinks'],
        templates: [
            { label: 'Relatorio SEO mensal', items: ['Trafego organico (sessoes, usuarios)', 'Rankings de palavras-chave', 'Novos backlinks adquiridos', 'Conversoes de origem organica', 'Acoes para o proximo mes'] }
        ]
    }
},

branding: {
    'essencia.missao': {
        suggestions: ['O que fazemos', 'Para quem fazemos', 'Como fazemos diferente', 'Impacto que geramos'],
        templates: [
            { label: 'Declaracao de missao', items: ['Nos [acao principal]', 'Para [publico-alvo]', 'Atraves de [abordagem/diferencial]', 'Com o objetivo de [impacto/resultado]'] }
        ]
    },
    'essencia.visao': {
        suggestions: ['Futuro desejado', 'Onde queremos chegar', 'Impacto de longo prazo', 'Posicionamento almejado'],
        templates: [
            { label: 'Declaracao de visao', items: ['Ser reconhecido como [posicao desejada]', 'No mercado de [setor/nicho]', 'Transformando [area de impacto]'] }
        ]
    },
    'essencia.valores': {
        suggestions: ['Inovacao', 'Transparencia', 'Excelencia', 'Colaboracao', 'Sustentabilidade', 'Respeito', 'Integridade', 'Criatividade'],
        templates: [
            { label: 'Valores fundamentais', items: ['Valor 1: [nome] - [comportamento]', 'Valor 2: [nome] - [comportamento]', 'Valor 3: [nome] - [comportamento]', 'Como vivemos esses valores no dia a dia'] }
        ]
    },
    'essencia.proposito': {
        suggestions: ['Por que existimos', 'Causa maior', 'Mudanca que queremos ver', 'Legado que deixamos'],
        templates: [
            { label: 'Declaracao de proposito', items: ['Existimos para [razao de ser]', 'Acreditamos que [crenca fundamental]', 'Trabalhamos para [mudanca desejada]'] }
        ]
    },
    'essencia.manifesto': {
        suggestions: ['Nossa historia', 'O que defendemos', 'O que rejeitamos', 'Nosso compromisso', 'Chamado para acao'],
        templates: [
            { label: 'Estrutura de manifesto', items: ['Abertura: declaracao provocativa', 'O problema: o que esta errado', 'Nossa crenca: o que defendemos', 'Nossa abordagem: como fazemos diferente', 'Chamado: convite para se juntar'] }
        ]
    },
    'personalidade.arquetipos': {
        suggestions: ['Criador', 'Sabio', 'Heroi', 'Rebelde', 'Magico', 'Explorador', 'Cuidador', 'Amante', 'Governante', 'Inocente'],
        templates: [
            { label: 'Arquetipo da marca', items: ['Arquetipo primario: [nome] - [descricao]', 'Arquetipo secundario: [nome] - [descricao]', 'Como isso se manifesta na comunicacao', 'Exemplos de marcas similares'] }
        ]
    },
    'personalidade.adjetivos': {
        suggestions: ['Inovadora', 'Confiavel', 'Acessivel', 'Sofisticada', 'Ousada', 'Acolhedora', 'Profissional', 'Autentica'],
        templates: [
            { label: 'Adjetivos de marca', items: ['Se a marca fosse uma pessoa, seria:', 'Adjetivo 1: [palavra] - [como aparece]', 'Adjetivo 2: [palavra] - [como aparece]', 'O que NAO somos: [adjetivos opostos]'] }
        ]
    },
    'personalidade.tom_emocional': {
        suggestions: ['Inspirador', 'Empatico', 'Confiante', 'Encorajador', 'Serio', 'Descontraido', 'Provocativo'],
        templates: [
            { label: 'Tom emocional', items: ['Emocao principal que queremos despertar', 'Em momentos de [contexto]: tom [adjetivo]', 'Emocoes a evitar', 'Exemplo de frase com o tom correto'] }
        ]
    },
    'personalidade.pilares': {
        suggestions: ['Autenticidade', 'Inovacao', 'Qualidade', 'Acessibilidade', 'Impacto social', 'Performance'],
        templates: [
            { label: 'Pilares de personalidade', items: ['Pilar 1: [nome] - [significado]', 'Pilar 2: [nome] - [significado]', 'Pilar 3: [nome] - [significado]', 'Exemplos praticos de aplicacao'] }
        ]
    },
    'naming.nome': {
        suggestions: ['Nome descritivo', 'Nome abstrato', 'Nome inventado', 'Acronimo', 'Nome do fundador', 'Combinacao de palavras'],
        templates: [
            { label: 'Definicao do nome', items: ['Nome escolhido: [nome completo]', 'Tipo: [descritivo/abstrato/inventado]', 'Disponibilidade: dominio e redes sociais', 'Registro de marca: status'] }
        ]
    },
    'naming.tagline': {
        suggestions: ['Beneficio claro', 'Descritivo', 'Provocativo', 'Aspiracional', 'Rima ou aliteracao'],
        templates: [
            { label: 'Tagline', items: ['Tagline principal: [frase]', 'O que comunica: [mensagem central]', 'Tom: [emocional/racional/inspirador]', 'Quando usar vs quando omitir'] }
        ]
    },
    'naming.significado': {
        suggestions: ['Etimologia', 'Historia por tras', 'Conexao com valores', 'Metafora ou simbolismo'],
        templates: [
            { label: 'Significado do nome', items: ['Origem ou etimologia', 'Por que esse nome foi escolhido', 'O que representa para a marca', 'Como comunicar isso ao publico'] }
        ]
    },
    'naming.variantes': {
        suggestions: ['Abreviacao', 'Versao curta', 'Versao completa', 'Nome fantasia vs razao social'],
        templates: [
            { label: 'Variantes do nome', items: ['Nome completo: [versao oficial]', 'Nome curto: [se aplicavel]', 'Quando usar cada variante', 'Consistencia em diferentes canais'] }
        ]
    },
    'logo.descricao': {
        suggestions: ['Simbolo + logotipo', 'Logotipo puro', 'Simbolo puro', 'Monograma', 'Emblema', 'Wordmark'],
        templates: [
            { label: 'Descricao do logo', items: ['Tipo: [wordmark/symbol/combination]', 'Elementos principais: [descricao visual]', 'Significado dos elementos', 'Paleta de cores do logo'] }
        ]
    },
    'logo.variantes': {
        suggestions: ['Horizontal', 'Vertical', 'Icone isolado', 'Monocromatico', 'Negativo', 'Simplificado'],
        templates: [
            { label: 'Variantes do logo', items: ['Versao principal: [quando usar]', 'Versao horizontal: [quando usar]', 'Icone isolado: [quando usar]', 'Versao monocromatica: [quando usar]'] }
        ]
    },
    'logo.area_protecao': {
        suggestions: ['Espaco minimo ao redor', 'Tamanho minimo', 'Regra de espacamento', 'Margem de seguranca'],
        templates: [
            { label: 'Area de protecao', items: ['Espaco minimo: [X unidades ao redor]', 'Tamanho minimo de reproducao: [px/mm]', 'Nunca colocar elementos dentro da area'] }
        ]
    },
    'logo.usos_incorretos': {
        suggestions: ['Nao distorcer', 'Nao mudar cores', 'Nao rotacionar', 'Nao adicionar efeitos', 'Nao usar em fundos inadequados'],
        templates: [
            { label: 'Usos incorretos', items: ['Nao distorcer ou esticar', 'Nao alterar proporcoes', 'Nao mudar as cores', 'Nao adicionar sombras ou efeitos', 'Nao usar em fundos com baixo contraste'] }
        ]
    },
    'cores.primarias': {
        suggestions: ['1-2 cores principais', 'Identidade visual forte', 'Contraste adequado', 'Significado das cores'],
        templates: [
            { label: 'Cores primarias', items: ['Cor primaria 1: [nome] - HEX [#] RGB [valores]', 'Cor primaria 2: [nome] - HEX [#] RGB [valores]', 'Uso: titulos, CTAs, elementos principais', 'Acessibilidade: contraste minimo WCAG AA'] }
        ]
    },
    'cores.secundarias': {
        suggestions: ['2-4 cores de suporte', 'Complementares', 'Versateis para variacoes'],
        templates: [
            { label: 'Cores secundarias', items: ['Cor secundaria 1: [nome] - HEX [#]', 'Cor secundaria 2: [nome] - HEX [#]', 'Uso: icones, ilustracoes, destaques'] }
        ]
    },
    'cores.neutras': {
        suggestions: ['Branco', 'Preto', 'Cinzas', 'Bege', 'Off-white', 'Tons de fundo'],
        templates: [
            { label: 'Paleta neutra', items: ['Preto/cinza escuro: [HEX] - textos', 'Cinza medio: [HEX] - subtextos', 'Cinza claro: [HEX] - bordas', 'Branco/off-white: [HEX] - fundos'] }
        ]
    },
    'cores.aplicacao': {
        suggestions: ['Hierarquia de cores', 'Proporcao 60-30-10', 'Fundos permitidos', 'Acessibilidade'],
        templates: [
            { label: 'Regras de aplicacao', items: ['Cor dominante (60%): [cor] - grandes areas', 'Cor secundaria (30%): [cor] - elementos medios', 'Cor de destaque (10%): [cor] - CTAs, icones', 'Combinacoes permitidas e proibidas'] }
        ]
    },
    'tipografia.principal': {
        suggestions: ['Sans-serif moderna', 'Serif classica', 'Geometrica', 'Humanista', 'Legibilidade prioritaria'],
        templates: [
            { label: 'Tipografia principal', items: ['Familia tipografica: [nome da fonte]', 'Pesos disponiveis: [regular, bold]', 'Uso: titulos, headings, destaques', 'Fallback web: [fontes alternativas]'] }
        ]
    },
    'tipografia.secundaria': {
        suggestions: ['Fonte para corpo', 'Alta legibilidade', 'Complementar a principal', 'Neutra e versatil'],
        templates: [
            { label: 'Tipografia secundaria', items: ['Familia: [nome da fonte]', 'Uso: paragrafos, corpo de texto', 'Tamanho base: 16px', 'Line-height: 1.5-1.8'] }
        ]
    },
    'tipografia.hierarquia': {
        suggestions: ['Escala tipografica', 'H1 a H6', 'Body, caption, small', 'Tamanhos e pesos'],
        templates: [
            { label: 'Hierarquia tipografica', items: ['H1: [fonte] [tamanho] [peso]', 'H2: [fonte] [tamanho] [peso]', 'H3: [fonte] [tamanho] [peso]', 'Body: [fonte] [tamanho] [peso]'] }
        ]
    },
    'tipografia.regras': {
        suggestions: ['Kerning e tracking', 'Alinhamento', 'Tamanhos minimos', 'Cores permitidas'],
        templates: [
            { label: 'Regras tipograficas', items: ['Tamanho minimo legivel: 12-14px', 'Alinhamento: esquerda/centralizado', 'Uso de all-caps: [quando permitido]', 'Nunca: distorcer, usar mais de 3 fontes'] }
        ]
    },
    'visuais.icones': {
        suggestions: ['Estilo consistente', 'Linha ou preenchido', 'Biblioteca propria', 'Tamanhos padrao'],
        templates: [
            { label: 'Sistema de icones', items: ['Estilo: [outline/filled/duotone]', 'Peso de linha: [1-2px]', 'Tamanhos padrao: [16px, 24px, 32px]', 'Cores: usar paleta da marca'] }
        ]
    },
    'visuais.ilustracoes': {
        suggestions: ['Estilo de ilustracao', 'Paleta de cores', 'Nivel de detalhe', 'Personagens ou objetos'],
        templates: [
            { label: 'Estilo de ilustracoes', items: ['Tipo: [flat/isometrico/linha/3D]', 'Paleta: usar cores da marca', 'Quando usar: hero sections, onboarding, vazios'] }
        ]
    },
    'visuais.fotografia': {
        suggestions: ['Estilo fotografico', 'Tratamento de cor', 'Composicao', 'Autentica vs stock'],
        templates: [
            { label: 'Diretrizes de fotografia', items: ['Estilo: [autentico/lifestyle/produto]', 'Tratamento: [cores vibrantes/natural]', 'Preferencia: fotos proprias vs stock', 'Uso de pessoas: diversidade, naturalidade'] }
        ]
    },
    'visuais.patterns': {
        suggestions: ['Padroes geometricos', 'Texturas', 'Elementos repetitivos', 'Fundos', 'Detalhes decorativos'],
        templates: [
            { label: 'Padroes e texturas', items: ['Tipo: [geometrico/organico/abstrato]', 'Opacidade: 10-30% para fundos', 'Uso: fundos de secoes, detalhes decorativos', 'Manter sutil e acessorio'] }
        ]
    },
    'aplicacoes.cartao': {
        suggestions: ['Frente e verso', 'Dados essenciais', 'Logo e cores', 'Acabamento', 'Tamanho padrao'],
        templates: [
            { label: 'Cartao de visita', items: ['Tamanho: 85x55mm padrao', 'Frente: logo, nome, cargo', 'Verso: contatos, site, redes', 'Papel e acabamento'] }
        ]
    },
    'aplicacoes.papelaria': {
        suggestions: ['Papel timbrado', 'Envelope', 'Pasta', 'Bloco de notas', 'Assinatura de e-mail'],
        templates: [
            { label: 'Sistema de papelaria', items: ['Papel timbrado: cabecalho com logo', 'Envelope: logo no canto superior', 'Assinatura de e-mail: logo, nome, cargo, contatos'] }
        ]
    },
    'aplicacoes.embalagens': {
        suggestions: ['Design de caixa', 'Etiquetas', 'Sacolas', 'Fitas adesivas', 'Unboxing experience'],
        templates: [
            { label: 'Sistema de embalagens', items: ['Tipo de embalagem: [caixa/sacola/envelope]', 'Aplicacao do logo', 'Informacoes obrigatorias', 'Sustentabilidade: materiais e reciclagem'] }
        ]
    },
    'aplicacoes.uniformes': {
        suggestions: ['Camisetas', 'Crachas', 'Aventais', 'Bones', 'Posicionamento do logo'],
        templates: [
            { label: 'Uniformes', items: ['Pecas: [camiseta, bone, etc]', 'Cores: seguir paleta da marca', 'Logo: [bordado/silk] posicao [peito/costa]'] }
        ]
    },
    'digital.redes': {
        suggestions: ['Foto de perfil', 'Capa', 'Destaques', 'Templates de posts', 'Tamanhos otimizados'],
        templates: [
            { label: 'Identidade em redes', items: ['Foto de perfil: logo em fundo [cor]', 'Capa/Banner: [elementos visuais]', 'Destaques Instagram: icones com identidade', 'Templates de posts: grid consistente'] }
        ]
    },
    'digital.site': {
        suggestions: ['Header e footer', 'Favicon', 'Paginas padrao', 'Responsividade'],
        templates: [
            { label: 'Identidade no site', items: ['Header: logo, menu, CTA', 'Footer: logo, links, redes sociais', 'Favicon: versao simplificada do logo', 'Cores e tipografia conforme guia'] }
        ]
    },
    'digital.email': {
        suggestions: ['Template HTML', 'Header de e-mail', 'Assinatura', 'Responsivo'],
        templates: [
            { label: 'Templates de e-mail', items: ['Header: logo e navegacao', 'CTAs: botoes com cores primarias', 'Footer: contatos, redes, descadastro', 'Responsivo e testado'] }
        ]
    },
    'digital.templates': {
        suggestions: ['Apresentacoes', 'Documentos', 'Planilhas', 'Posts sociais', 'Anuncios'],
        templates: [
            { label: 'Biblioteca de templates', items: ['Apresentacao: capa, slides internos', 'Posts sociais: feed, stories, carrossel', 'Anuncios digitais: tamanhos padrao', 'Disponibilizar em formatos editaveis'] }
        ]
    },
    'manual.dos': {
        suggestions: ['Usar cores corretas', 'Seguir hierarquia', 'Manter proporcoes', 'Usar templates', 'Consistencia'],
        templates: [
            { label: 'Boas praticas', items: ['SEMPRE usar as cores oficiais', 'SEMPRE manter proporcoes do logo', 'SEMPRE seguir hierarquia tipografica', 'SEMPRE usar templates aprovados'] }
        ]
    },
    'manual.donts': {
        suggestions: ['Nao distorcer logo', 'Nao usar cores aleatorias', 'Nao ignorar espacamento', 'Nao improvisar'],
        templates: [
            { label: 'Praticas a evitar', items: ['NUNCA distorcer ou esticar o logo', 'NUNCA usar cores fora da paleta', 'NUNCA ignorar a area de protecao', 'NUNCA adicionar efeitos nao autorizados'] }
        ]
    },
    'manual.exemplos': {
        suggestions: ['Casos de uso', 'Antes e depois', 'Aplicacoes corretas', 'Erros comuns', 'Mockups'],
        templates: [
            { label: 'Galeria de exemplos', items: ['Aplicacoes corretas: mockups e fotos reais', 'Erros comuns: exemplos do que nao fazer', 'Casos especiais: solucoes para contextos unicos'] }
        ]
    },
    'manual.atualizacao': {
        suggestions: ['Controle de versao', 'Responsavel', 'Periodicidade', 'Comunicacao de mudancas'],
        templates: [
            { label: 'Controle do manual', items: ['Versao atual: [numero e data]', 'Responsavel por atualizacoes', 'Periodicidade de revisao: [anual/semestral]', 'Comunicacao de novas versoes para equipe'] }
        ]
    }
},

'google-ads': {
    'estrategia.objetivo': {
        suggestions: ['Conversoes', 'Trafego qualificado', 'Branding', 'Leads qualificados', 'Vendas online', 'Reconhecimento'],
        templates: [
            { label: 'E-commerce', items: ['Aumentar vendas em 30% no trimestre', 'Reduzir CPA para R$ 25', 'ROAS minimo de 4:1', 'Volume minimo de 100 conversoes/mes'] },
            { label: 'Geracao de Leads', items: ['50 leads qualificados por mes', 'CPL maximo de R$ 40', 'Taxa de conversao LP > 8%'] }
        ]
    },
    'estrategia.orcamento': {
        suggestions: ['R$ 1.000/mes', 'R$ 3.000/mes', 'R$ 5.000/mes', 'R$ 10.000/mes', 'Budget flexivel'],
        templates: [
            { label: 'Distribuicao inicial', items: ['60% Search', '20% Display/Remarketing', '15% Shopping/PMAX', '5% YouTube/Video'] }
        ]
    },
    'estrategia.cpa_alvo': {
        suggestions: ['R$ 20', 'R$ 50', 'R$ 100', 'R$ 200', 'Baseado em LTV', 'Maximizar conversoes'],
        templates: [
            { label: 'Calculo CPA', items: ['Margem de lucro: R$ X', 'LTV do cliente: R$ Y', 'CPA maximo viavel: 30% do LTV'] }
        ]
    },
    'estrategia.kpis': {
        suggestions: ['CTR', 'CPC', 'Taxa de conversao', 'ROAS', 'Quality Score', 'Custo por lead'],
        templates: [
            { label: 'KPIs principais', items: ['CTR > 3% em Search', 'Taxa de conversao > 5%', 'ROAS > 300%', 'Quality Score medio > 7'] }
        ]
    },
    'estrategia.funil': {
        suggestions: ['ToFu', 'MoFu', 'BoFu', 'Remarketing', 'Consideracao', 'Decisao'],
        templates: [
            { label: 'Funil completo', items: ['ToFu: Display/YouTube (awareness)', 'MoFu: Search generico + remarketing', 'BoFu: Search marca + Shopping', 'Pos-venda: Upsell/Cross-sell'] }
        ]
    },
    'conta.campanhas': {
        suggestions: ['Search Marca', 'Search Generica', 'Shopping', 'Display', 'PMAX', 'YouTube', 'Remarketing'],
        templates: [
            { label: 'Estrutura basica', items: ['Campanha 1: Search Marca', 'Campanha 2: Search Produto Principal', 'Campanha 3: Shopping Feed', 'Campanha 4: Remarketing Display', 'Campanha 5: PMAX'] }
        ]
    },
    'conta.nomenclatura': {
        suggestions: ['BR_Search_Marca', 'BR_Shopping_Feed', 'BR_Display_Rmkt', 'Prefixo por pais'],
        templates: [
            { label: 'Padrao de nomenclatura', items: ['Formato: [PAIS]_[TIPO]_[OBJETIVO]_[PRODUTO]', 'Exemplo: BR_Search_Conversao_TenisEsportivo', 'Grupos: GrupoAnuncio_PalavraPrincipal'] }
        ]
    },
    'conta.localizacao': {
        suggestions: ['Brasil todo', 'Sao Paulo', 'Capitais', 'Regiao Sul', 'Raio de 20km'],
        templates: [
            { label: 'Segmentacao geografica', items: ['Principais: SP, RJ, MG, RS, PR', 'Ajuste de lance: +20% capitais', 'Exclusoes: zonas sem delivery'] }
        ]
    },
    'conta.programacao': {
        suggestions: ['Comercial 9h-18h', '24/7', 'Fins de semana +30%', 'Pausar madrugada'],
        templates: [
            { label: 'Horarios otimizados', items: ['Segunda a sexta: 8h-22h', 'Sabado: 9h-20h', 'Picos de conversao: 10h-12h e 19h-21h (+20%)'] }
        ]
    },
    'palavras.principais': {
        suggestions: ['Tenis esportivo', 'Curso online', 'Advogado trabalhista', 'Notebook gamer'],
        templates: [
            { label: 'Lista principal', items: ['10-15 palavras de alto volume', 'Relacionadas ao produto core', 'Intencao comercial clara', 'Volume mensal > 500 buscas'] }
        ]
    },
    'palavras.secundarias': {
        suggestions: ['Variacoes', 'Sinonimos', 'Regionalismos', 'Termos relacionados', 'Complementos'],
        templates: [
            { label: 'Expansao semantica', items: ['Variacoes de genero/numero', 'Sinonimos do setor', 'Termos de cauda media (100-500 buscas/mes)'] }
        ]
    },
    'palavras.long_tail': {
        suggestions: ['Comprar + marca', 'Preco + cidade', 'Melhor + segmento', 'Como escolher'],
        templates: [
            { label: 'Long tail convertedora', items: ['melhor [produto] para [situacao]', 'onde comprar [produto] em [cidade]', '[produto] [marca] preco', '[produto A] vs [produto B]'] }
        ]
    },
    'palavras.negativas': {
        suggestions: ['Gratis', 'Pirata', 'Usado', 'Curso', 'Tutorial', 'Download', 'PDF'],
        templates: [
            { label: 'Negativas nivel conta', items: ['gratis, gratuito, free', 'usado, segunda mao', 'pirata, crackeado', 'curso, como fazer, tutorial', 'vagas, emprego'] }
        ]
    },
    'palavras.correspondencia': {
        suggestions: ['Exata', 'Frase', 'Ampla modificada', 'Ampla', 'Combinacao estrategica'],
        templates: [
            { label: 'Estrategia de correspondencia', items: ['Marca: [exata] para controle total', 'Principais: "frase" para equilibrio', 'Long tail: ampla (com negativas robustas)'] }
        ]
    },
    'search.headlines': {
        suggestions: ['Beneficio principal', 'Preco/Desconto', 'Urgencia', 'Diferencial', 'Call to action', 'Prova social'],
        templates: [
            { label: 'Formulas de titulos', items: ['[Produto] + [Diferencial]', '[Beneficio] + [Prova Social]', '[Oferta] + [Urgencia]', '[CTA] + [Garantia]'] }
        ]
    },
    'search.descricoes': {
        suggestions: ['Beneficios', 'Especificacoes', 'Garantia', 'Envio', 'Diferenciais'],
        templates: [
            { label: 'Set de descricoes', items: ['Tecnologia avancada. Conforto garantido. Material premium.', 'Frete gratis para todo Brasil. Troca facil em 30 dias.', 'Site seguro. Pagamento em ate 12x. Compra protegida.'] }
        ]
    },
    'search.extensoes': {
        suggestions: ['Sitelinks', 'Chamadas', 'Snippets', 'Preco', 'Localizacao', 'Promocao'],
        templates: [
            { label: 'Extensoes essenciais', items: ['Sitelinks: Produtos | Sobre | Contato | FAQ', 'Snippets estruturados: Marcas, Tamanhos, Cores', 'Extensao de promocao: 15% OFF primeira compra'] }
        ]
    },
    'search.testes': {
        suggestions: ['Teste A/B titulos', 'Variacao CTA', 'Com/sem preco', 'Urgencia vs beneficio'],
        templates: [
            { label: 'Plano de testes', items: ['Semana 1-2: 3 variacoes de titulo principal', 'Semana 3-4: CTA (Compre Agora vs Aproveite)', 'Minimo 100 impressoes por variacao', 'Metrica: CTR e taxa de conversao'] }
        ]
    },
    'search.por_grupo': {
        suggestions: ['3-5 anuncios', 'Variacoes de beneficio', 'Teste continuo', 'Pin estrategico'],
        templates: [
            { label: 'Grupo de anuncios', items: ['7-10 palavras-chave relacionadas', '3 anuncios RSA por grupo', '15 titulos + 4 descricoes por anuncio'] }
        ]
    },
    'shopping.feed': {
        suggestions: ['Google Merchant Center', 'Atualizacao diaria', 'Campos obrigatorios', 'Otimizacao de titulos'],
        templates: [
            { label: 'Configuracao do feed', items: ['Integracao via XML/API automatica', 'Campos: id, title, description, link, image_link, price, availability', 'Titulos: Marca + Modelo + Caracteristica + Tamanho/Cor'] }
        ]
    },
    'shopping.titulos_feed': {
        suggestions: ['Marca primeiro', 'Palavra-chave', 'Especificacoes', 'Cor/Tamanho'],
        templates: [
            { label: 'Formula de titulo', items: ['[Marca] [Modelo] [Tipo] [Caracteristica] [Tamanho/Cor]', 'Maximo 150 caracteres', 'Palavras-chave no inicio'] }
        ]
    },
    'shopping.campanhas_shopping': {
        suggestions: ['Standard Shopping', 'Smart Shopping', 'PMAX', 'Segmentacao por produto'],
        templates: [
            { label: 'Estrutura Shopping', items: ['Campanha 1: Shopping Standard (controle manual)', 'Campanha 2: PMAX (automacao + assets)', 'Prioridade Alta: produtos best-sellers'] }
        ]
    },
    'shopping.exclusoes': {
        suggestions: ['Produtos sem estoque', 'Margem baixa', 'Sazonais fora de epoca', 'Pre-venda'],
        templates: [
            { label: 'Regras de exclusao', items: ['availability = "out of stock"', 'Margem < 20%', 'Categorias com ROAS < 150% apos 30 dias'] }
        ]
    },
    'display.banners': {
        suggestions: ['300x250', '728x90', '160x600', 'Responsivos', 'HTML5'],
        templates: [
            { label: 'Kit de banners', items: ['Tamanhos: 300x250, 728x90, 160x600, 320x50 (mobile)', 'Formatos: JPG estatico + HTML5 animado', 'CTA claro e visivel'] }
        ]
    },
    'display.remarketing': {
        suggestions: ['Visitantes site', 'Carrinho abandonado', 'Compradores', 'Engajamento video'],
        templates: [
            { label: 'Listas de remarketing', items: ['Visitaram site (ultimos 30 dias)', 'Carrinho abandonado (ultimos 7 dias)', 'Compraram (ultimos 90 dias) - upsell', 'Exclusao: compradores recentes (<7 dias)'] }
        ]
    },
    'display.segmentacao': {
        suggestions: ['Demografica', 'Interesses', 'Intencao de compra', 'Remarketing', 'Placements'],
        templates: [
            { label: 'Segmentacao Display', items: ['Demografica: idade 25-45, renda alta', 'Afinidade: entusiastas do nicho', 'Intencao: procurando por [produto]', 'Exclusao: apps de jogos'] }
        ]
    },
    'display.exclusoes_display': {
        suggestions: ['Conteudo adulto', 'Apps de jogos', 'Sites de noticias', 'Placements ruins'],
        templates: [
            { label: 'Exclusoes nivel conta', items: ['Conteudo sensivel (violencia, adulto)', 'Apps infantis e jogos casuais', 'Exclusoes de placement apos analise semanal'] }
        ]
    },
    'youtube.formatos': {
        suggestions: ['In-Stream pulavel', 'Bumper 6s', 'Discovery', 'Shorts', 'Masthead'],
        templates: [
            { label: 'Mix de formatos', items: ['In-Stream Pulavel: awareness (15-30s)', 'Bumper Ads: reforco de mensagem (6s)', 'Discovery: leads (thumbnail atraente)'] }
        ]
    },
    'youtube.roteiros': {
        suggestions: ['Hook 3s', 'Problema-Solucao', 'Depoimento', 'Demonstracao', 'CTA claro'],
        templates: [
            { label: 'Estrutura de video', items: ['0-3s: Hook visual impactante', '3-10s: Apresenta problema', '10-20s: Mostra solucao (produto)', '20-25s: Beneficios + prova social', '25-30s: CTA claro'] }
        ]
    },
    'youtube.segmentacao_yt': {
        suggestions: ['Canais especificos', 'Videos similares', 'Palavras-chave', 'Topicos'],
        templates: [
            { label: 'Segmentacao YouTube', items: ['Canais: top 20 do nicho', 'Palavras-chave: termos de busca do publico', 'Publicos: remarketing site + semelhante'] }
        ]
    },
    'youtube.metricas_yt': {
        suggestions: ['Taxa de visualizacao', 'CPV', 'Visualizacoes 25/50/75%', 'Conversoes assistidas'],
        templates: [
            { label: 'KPIs YouTube', items: ['Taxa de visualizacao > 30%', 'CPV abaixo de R$ 0,30', 'CTR > 1% (Discovery)', 'Conversoes view-through'] }
        ]
    },
    'pmax.assets': {
        suggestions: ['15 imagens', '5 logos', '5 videos', 'Headlines', 'Descricoes longas'],
        templates: [
            { label: 'Assets PMAX', items: ['Imagens: 15 (quadradas + horizontais + verticais)', 'Videos: 5 (horizontal, quadrado, vertical)', 'Titulos: 5 curtos (30 caracteres)', 'Descricoes: 5 longas (90 caracteres)'] }
        ]
    },
    'pmax.sinais': {
        suggestions: ['Publicos customizados', 'Dados de conversao', 'Segmentos demograficos', 'URLs'],
        templates: [
            { label: 'Sinais de publico', items: ['Compradores ultimos 90 dias', 'Carrinho abandonado', 'Semelhante a clientes (lookalike)', 'Palavras-chave de intencao'] }
        ]
    },
    'pmax.metas': {
        suggestions: ['Maximizar conversoes', 'CPA alvo', 'ROAS alvo', 'Valor de conversao'],
        templates: [
            { label: 'Configuracao de meta', items: ['Inicio: Maximizar conversoes (aprendizado)', 'Apos 30 conversoes: CPA alvo', 'Ou ROAS alvo 400%', 'Conversao principal: compra'] }
        ]
    },
    'pmax.controle': {
        suggestions: ['Insights de assets', 'Relatorio de canais', 'Exclusoes', 'Listing groups'],
        templates: [
            { label: 'Monitoramento PMAX', items: ['Insights semanais: qual asset performa melhor', 'Relatorio de canais: YouTube, Display, Search, Shopping', 'Exclusoes: placements de baixa performance'] }
        ]
    },
    'landing.urls': {
        suggestions: ['Por grupo de anuncios', 'Por palavra-chave', 'Landing especifica', 'Parametros UTM'],
        templates: [
            { label: 'Estrategia de URLs', items: ['LP especifica por produto principal', 'UTMs em todas as URLs', 'Garantir LP mobile-friendly', 'Mensagem do anuncio = headline da LP'] }
        ]
    },
    'landing.elementos': {
        suggestions: ['Headline forte', 'CTA acima da dobra', 'Prova social', 'Beneficios', 'Urgencia'],
        templates: [
            { label: 'Checklist LP', items: ['Headline espelha promessa do anuncio', 'CTA visivel e repetido', 'Prova social: avaliacoes, selos', 'Beneficios em bullets', 'Formulario: maximo 3 campos'] }
        ]
    },
    'landing.rastreamento': {
        suggestions: ['Google Analytics 4', 'Google Tag Manager', 'Pixel de conversao', 'Eventos customizados'],
        templates: [
            { label: 'Setup de rastreamento', items: ['GA4: evento de conversao configurado', 'GTM: tags de clique em CTA', 'Pixel do Google Ads: conversao', 'Heatmap (Hotjar): comportamento'] }
        ]
    },
    'landing.testes_lp': {
        suggestions: ['Headline', 'CTA', 'Imagem hero', 'Cor do botao', 'Formulario'],
        templates: [
            { label: 'Teste A/B da LP', items: ['Headline com beneficio vs com urgencia', 'CTA "Compre Agora" vs "Aproveite Oferta"', 'Imagem produto vs pessoa usando', 'Minimo 1000 visitantes por variacao'] }
        ]
    },
    'otimizacao.rotina': {
        suggestions: ['Diaria', 'Semanal', 'Quinzenal', 'Mensal', 'Checklist'],
        templates: [
            { label: 'Rotina de otimizacao', items: ['Diario: verificar budget, pausar CPC alto', 'Semanal: termos de pesquisa + negativas', 'Quinzenal: ajuste de lances', 'Mensal: relatorio completo'] }
        ]
    },
    'otimizacao.lances': {
        suggestions: ['CPA alvo', 'ROAS alvo', 'Maximizar conversoes', 'CPC manual'],
        templates: [
            { label: 'Estrategia de lances', items: ['Inicio: CPC manual ou Maximizar cliques', 'Apos 15-30 conversoes: CPA alvo', 'Ajustes: +20% mobile se performa melhor', '+30% em capitais de alta conversao'] }
        ]
    },
    'otimizacao.quality_score': {
        suggestions: ['Relevancia do anuncio', 'CTR esperado', 'Experiencia na LP', 'Palavras-chave especificas'],
        templates: [
            { label: 'Melhorar Quality Score', items: ['Palavra-chave no titulo do anuncio', 'Palavra-chave na URL e headline da LP', 'CTR > 5% em Search', 'LP rapida e mobile-friendly'] }
        ]
    },
    'otimizacao.escala': {
        suggestions: ['Aumentar budget', 'Novos grupos', 'Expandir geo', 'Novas palavras', 'Novos canais'],
        templates: [
            { label: 'Plano de escala', items: ['Aumentar budget +20% a cada 7 dias', 'Duplicar campanhas vencedoras', 'Expandir para novas regioes', 'Testar novos formatos: YouTube, Discovery'] }
        ]
    },
    'otimizacao.concorrentes': {
        suggestions: ['Analise de anuncios', 'Palavras-chave deles', 'Extensoes', 'Ofertas', 'Diferenciacao'],
        templates: [
            { label: 'Analise competitiva', items: ['Ferramenta: Semrush, SpyFu ou busca manual', 'Mapear principais palavras dos concorrentes', 'Identificar gaps que voce pode explorar', 'Destacar seu diferencial nos anuncios'] }
        ]
    }
},

performance: {
    'core-vitals.lcp': {
        suggestions: ['Otimizar imagens hero', 'Preload recursos', 'CDN', 'Lazy load', 'Reduzir tamanho'],
        templates: [
            { label: 'Melhorar LCP', items: ['Meta: LCP < 2.5s', 'Otimizar imagem hero: WebP, tamanho adequado', 'Preload da imagem principal', 'Usar CDN para servir imagens', 'Reduzir CSS/JS bloqueante'] }
        ]
    },
    'core-vitals.inp': {
        suggestions: ['Reduzir JS', 'Debounce eventos', 'Web Workers', 'Code splitting', 'Otimizar interacoes'],
        templates: [
            { label: 'Melhorar INP', items: ['Meta: INP < 200ms', 'Reduzir JavaScript desnecessario', 'Debounce/throttle em scroll e resize', 'Evitar long tasks (> 50ms)'] }
        ]
    },
    'core-vitals.cls': {
        suggestions: ['Dimensoes em imagens', 'Reservar espaco ads', 'Fontes system', 'Skeleton loaders'],
        templates: [
            { label: 'Eliminar CLS', items: ['Meta: CLS < 0.1', 'Definir width e height em todas as imagens', 'Reservar espaco para ads e widgets', 'Usar font-display: swap', 'Skeleton loader em vez de conteudo que pula'] }
        ]
    },
    'core-vitals.ttfb': {
        suggestions: ['CDN', 'Cache de servidor', 'Otimizar backend', 'HTTP/2', 'Compressao Brotli'],
        templates: [
            { label: 'Reduzir TTFB', items: ['Meta: TTFB < 600ms', 'Usar CDN (Cloudflare)', 'Habilitar cache do servidor', 'Otimizar queries de banco', 'Compressao Brotli'] }
        ]
    },
    'imagens.formatos': {
        suggestions: ['WebP', 'AVIF', 'SVG vetoriais', 'Fallback JPEG', 'PNG so para transparencia'],
        templates: [
            { label: 'Estrategia de formatos', items: ['Prioridade: WebP (-30% tamanho)', 'Futuro: AVIF (melhor compressao)', 'Icones e logos: SVG', 'Fallback: JPEG otimizado'] }
        ]
    },
    'imagens.responsivo': {
        suggestions: ['srcset', 'sizes', 'picture', 'Art direction', 'Breakpoints'],
        templates: [
            { label: 'Imagens responsivas', items: ['srcset com multiplas resolucoes: 320w, 640w, 1024w', 'Atributo sizes para contexto', 'Picture para art direction', 'Gerar variacoes automaticamente'] }
        ]
    },
    'imagens.lazy': {
        suggestions: ['loading="lazy"', 'Intersection Observer', 'Eager nas hero', 'Placeholder blur'],
        templates: [
            { label: 'Lazy loading', items: ['Atributo nativo: loading="lazy"', 'Eager nas imagens acima da dobra', 'Lazy em iframes (YouTube, mapas)', 'Placeholder blur-up'] }
        ]
    },
    'imagens.cdn': {
        suggestions: ['Cloudflare Images', 'Imgix', 'Cloudinary', 'Otimizacao automatica'],
        templates: [
            { label: 'CDN de imagens', items: ['Cloudflare Images: otimizacao + entrega global', 'Automatic WebP/AVIF serving', 'Cache agressivo com headers HTTP'] }
        ]
    },
    'cache.browser': {
        suggestions: ['Cache-Control', 'Versionamento assets', 'Service Worker', 'ETags'],
        templates: [
            { label: 'Headers de cache', items: ['Assets versionados: max-age=31536000, immutable', 'HTML: no-cache (sempre revalidar)', 'CSS/JS: fingerprint no nome (style.a3f8d.css)'] }
        ]
    },
    'cache.cdn': {
        suggestions: ['Cloudflare', 'Fastly', 'CloudFront', 'Cache rules', 'Purge strategy'],
        templates: [
            { label: 'CDN caching', items: ['TTL: HTML 2h, CSS/JS 1 mes, imagens 1 ano', 'Purge automatico em deploy', 'Meta: cache hit rate > 90%'] }
        ]
    },
    'cache.pagina': {
        suggestions: ['Cache de HTML', 'Redis', 'Varnish', 'Invalidacao', 'Cache parcial'],
        templates: [
            { label: 'Cache de pagina', items: ['Redis para cache de HTML renderizado', 'TTL: 5-15 min para paginas dinamicas', 'Invalidacao apos update de conteudo', 'Bypass para usuarios logados'] }
        ]
    },
    'cache.service_worker': {
        suggestions: ['Workbox', 'Cache-first', 'Network-first', 'Offline fallback', 'Precache'],
        templates: [
            { label: 'Service Worker', items: ['Workbox para gerenciar estrategias', 'Precache: CSS, JS, fontes essenciais', 'Cache-first para assets, Network-first para API', 'Offline fallback page'] }
        ]
    },
    'codigo.minificacao': {
        suggestions: ['Terser', 'cssnano', 'HTMLMinifier', 'Build automatico'],
        templates: [
            { label: 'Minificacao', items: ['JS: Terser', 'CSS: cssnano', 'HTML: HTMLMinifier', 'Remover console.log em producao'] }
        ]
    },
    'codigo.css': {
        suggestions: ['Critical CSS', 'Remover unused', 'PurgeCSS', 'Minificar'],
        templates: [
            { label: 'Otimizacao CSS', items: ['Critical CSS inline no head', 'Carregar resto do CSS assincronamente', 'PurgeCSS: remover classes nao usadas', 'Evitar @import'] }
        ]
    },
    'codigo.js': {
        suggestions: ['Code splitting', 'Tree shaking', 'Dynamic import', 'Defer/async'],
        templates: [
            { label: 'Otimizacao JS', items: ['Code splitting por rota', 'Tree shaking: remover codigo morto', 'Script tags: defer ou async', 'Substituir libs pesadas por alternativas leves'] }
        ]
    },
    'codigo.fontes': {
        suggestions: ['font-display swap', 'WOFF2', 'Subset', 'Preload', 'System fonts'],
        templates: [
            { label: 'Otimizacao de fontes', items: ['Formato: WOFF2', 'font-display: swap', 'Subset: apenas caracteres usados', 'Preload fontes criticas'] }
        ]
    },
    'servidor.http': {
        suggestions: ['HTTP/2', 'HTTP/3', 'Multiplexing', 'Keep-alive'],
        templates: [
            { label: 'Protocolo HTTP', items: ['Habilitar HTTP/2', 'Testar HTTP/3 se CDN suportar', 'Keep-Alive habilitado', 'Reduzir numero de dominios'] }
        ]
    },
    'servidor.compressao': {
        suggestions: ['Gzip', 'Brotli', 'Compressao dinamica', 'Tipos de arquivo'],
        templates: [
            { label: 'Compressao', items: ['Brotli (melhor que Gzip)', 'Comprimir: HTML, CSS, JS, JSON, SVG', 'Nao comprimir: imagens ja comprimidas'] }
        ]
    },
    'servidor.prefetch': {
        suggestions: ['DNS prefetch', 'Preconnect', 'Prefetch', 'Preload', 'Modulepreload'],
        templates: [
            { label: 'Resource hints', items: ['dns-prefetch para dominios externos', 'preconnect para CDN', 'preload para CSS critico e fontes', 'prefetch para proxima pagina'] }
        ]
    },
    'servidor.backend': {
        suggestions: ['Otimizar queries', 'Indexes DB', 'N+1 queries', 'Cache de queries'],
        templates: [
            { label: 'Performance backend', items: ['Adicionar indexes em colunas filtradas', 'Resolver N+1 queries', 'Cache de queries repetitivas (Redis)', 'Monitorar slow queries (> 100ms)'] }
        ]
    },
    'monitoramento.pagespeed': {
        suggestions: ['PageSpeed Insights', 'Score 90+', 'Mobile-first', 'Monitorar semanalmente'],
        templates: [
            { label: 'PageSpeed Insights', items: ['Rodar semanalmente em paginas principais', 'Meta: score 90+ mobile e desktop', 'Focar em Core Web Vitals', 'Documentar score antes/depois'] }
        ]
    },
    'monitoramento.lighthouse': {
        suggestions: ['Lighthouse CI', 'Performance budget', 'Automatizado', 'Pull requests'],
        templates: [
            { label: 'Lighthouse CI', items: ['Integrar no CI/CD', 'Performance budget: LCP < 2.5s', 'Rodar em cada PR', 'Historico de scores'] }
        ]
    },
    'monitoramento.rum': {
        suggestions: ['Google Analytics 4', 'Web Vitals', 'Real User Monitoring', 'Percentil 75'],
        templates: [
            { label: 'RUM', items: ['Implementar Web Vitals em GA4', 'Monitorar no percentil 75', 'Segmentar: por dispositivo, geo, conexao', 'Alertas se Core Web Vitals sairem da meta'] }
        ]
    },
    'monitoramento.budget': {
        suggestions: ['Tamanho maximo JS', 'Tamanho maximo CSS', 'Total page weight', 'Requests'],
        templates: [
            { label: 'Performance Budget', items: ['JS total: < 300KB (gzipped)', 'CSS total: < 100KB (gzipped)', 'Page weight: < 1MB (mobile)', 'LCP: < 2.5s, INP: < 200ms, CLS: < 0.1'] }
        ]
    }
},

analytics: {
    'configuracao.ga4': {
        suggestions: ['Criar propriedade', 'Data streams', 'Enhanced measurement', 'Conversoes', 'Funis'],
        templates: [
            { label: 'Setup GA4', items: ['Criar propriedade GA4', 'Configurar data stream (Web)', 'Habilitar Enhanced Measurement', 'Definir eventos de conversao', 'Vincular Google Ads e Search Console'] }
        ]
    },
    'configuracao.gtm': {
        suggestions: ['Container web', 'Variaveis', 'Triggers', 'Tags GA4', 'Data Layer'],
        templates: [
            { label: 'Google Tag Manager', items: ['Criar container GTM', 'Instalar snippet no head', 'Tag GA4: configuracao + eventos', 'Modo Preview para testar'] }
        ]
    },
    'configuracao.gsc': {
        suggestions: ['Verificar propriedade', 'Submeter sitemap', 'Monitorar cobertura', 'Core Web Vitals'],
        templates: [
            { label: 'Search Console', items: ['Verificar propriedade (DNS ou HTML)', 'Submeter sitemap.xml', 'Monitorar cobertura', 'Vincular com GA4'] }
        ]
    },
    'configuracao.outras': {
        suggestions: ['Hotjar', 'Clarity', 'Mixpanel', 'Amplitude', 'Heap', 'Segment'],
        templates: [
            { label: 'Ferramentas complementares', items: ['Hotjar/Clarity: heatmaps, gravacoes', 'Mixpanel/Amplitude: comportamento e coortes', 'Escolher 1-2 alem de GA4'] }
        ]
    },
    'eventos.customizados': {
        suggestions: ['Clique em CTA', 'Download PDF', 'Scroll 50%', 'Tempo na pagina', 'Video assistido'],
        templates: [
            { label: 'Eventos customizados', items: ['click_cta: cliques em botoes principais', 'file_download: download de PDFs', 'scroll_depth: 25%, 50%, 75%, 100%', 'form_start / form_submit'] }
        ]
    },
    'eventos.conversoes': {
        suggestions: ['Compra', 'Lead', 'Cadastro', 'Ligacao', 'Chat', 'Agendamento'],
        templates: [
            { label: 'Eventos de conversao', items: ['purchase: transacao finalizada', 'generate_lead: formulario enviado', 'sign_up: cadastro de usuario', 'Importar conversoes para Google Ads'] }
        ]
    },
    'eventos.ecommerce': {
        suggestions: ['view_item', 'add_to_cart', 'begin_checkout', 'purchase', 'refund'],
        templates: [
            { label: 'Eventos e-commerce GA4', items: ['view_item: visualizacao de produto', 'add_to_cart: adicionar ao carrinho', 'begin_checkout: iniciar checkout', 'purchase: compra finalizada', 'refund: devolucao'] }
        ]
    },
    'eventos.datalayer': {
        suggestions: ['window.dataLayer', 'push eventos', 'user_id', 'custom dimensions'],
        templates: [
            { label: 'Data Layer', items: ['window.dataLayer = window.dataLayer || []', 'dataLayer.push({ event: "purchase", value: 199.90 })', 'Incluir user_id para cross-device', 'Documentar estrutura do dataLayer'] }
        ]
    },
    'campanhas.nomenclatura': {
        suggestions: ['utm_source', 'utm_medium', 'utm_campaign', 'utm_content', 'utm_term'],
        templates: [
            { label: 'Padrao de UTMs', items: ['utm_source: google, facebook, email', 'utm_medium: cpc, social, email', 'utm_campaign: nome_campanha', 'Documentar nomenclatura em planilha'] }
        ]
    },
    'campanhas.ativas': {
        suggestions: ['Google Ads', 'Meta Ads', 'Email marketing', 'Influenciadores', 'Afiliados'],
        templates: [
            { label: 'Rastreamento de campanhas', items: ['Google Ads: vinculacao automatica GA4', 'Meta Ads: UTMs manuais', 'Email: UTMs por campanha + segmento', 'Influenciadores: link unico com UTM'] }
        ]
    },
    'campanhas.ferramenta': {
        suggestions: ['Google Campaign URL Builder', 'Planilha de UTMs', 'Bitly rastreavel', 'QR codes'],
        templates: [
            { label: 'Ferramentas de rastreamento', items: ['Google Campaign URL Builder', 'Planilha compartilhada de UTMs', 'QR codes com UTMs para materiais fisicos', 'Validar UTMs antes de lancar'] }
        ]
    },
    'campanhas.atribuicao': {
        suggestions: ['Ultimo clique', 'Primeiro clique', 'Linear', 'Data-driven', 'Position-based'],
        templates: [
            { label: 'Modelos de atribuicao', items: ['Data-driven (padrao GA4): baseado em ML', 'Ultimo clique: atribui ao ultimo canal', 'Comparar modelos em Advertising > Attribution'] }
        ]
    },
    'relatorios.kpis': {
        suggestions: ['Sessoes', 'Usuarios', 'Taxa de conversao', 'Ticket medio', 'CAC', 'LTV', 'ROAS'],
        templates: [
            { label: 'KPIs principais', items: ['Sessoes e usuarios ativos', 'Taxa de conversao por canal', 'Receita total e por campanha', 'CAC e LTV'] }
        ]
    },
    'relatorios.dashboards': {
        suggestions: ['Looker Studio', 'Dashboard executivo', 'Dashboard de campanhas', 'E-commerce'],
        templates: [
            { label: 'Dashboards Looker Studio', items: ['Executivo: visao geral mensal', 'Campanhas: performance por canal', 'E-commerce: funil de compra', 'Agendar envio automatico semanal'] }
        ]
    },
    'relatorios.periodicos': {
        suggestions: ['Diario', 'Semanal', 'Mensal', 'Trimestral', 'Alertas automaticos'],
        templates: [
            { label: 'Rotina de relatorios', items: ['Diario: verificar anomalias', 'Semanal: relatorio de campanhas ativas', 'Mensal: relatorio executivo completo', 'Alertas: configurar no GA4 para quedas > 20%'] }
        ]
    },
    'relatorios.segmentacao': {
        suggestions: ['Por dispositivo', 'Por localizacao', 'Por canal', 'Por produto', 'Por publico'],
        templates: [
            { label: 'Segmentacoes uteis', items: ['Dispositivo: mobile vs desktop', 'Canal de aquisicao: organic, paid, social', 'Publico: novo vs recorrente', 'Comportamento: compradores vs nao-compradores'] }
        ]
    },
    'funis.principal': {
        suggestions: ['Awareness', 'Consideracao', 'Conversao', 'Retencao', 'Funil de vendas'],
        templates: [
            { label: 'Funil e-commerce', items: ['Sessoes no site', 'Visualizacao de produto', 'Adicionar ao carrinho', 'Iniciar checkout', 'Compra finalizada'] },
            { label: 'Funil de leads', items: ['Visita a landing page', 'Iniciar formulario', 'Enviar formulario (conversao)'] }
        ]
    },
    'funis.secundarios': {
        suggestions: ['Cadastro', 'Newsletter', 'Download', 'Video', 'Engajamento'],
        templates: [
            { label: 'Funis secundarios', items: ['Funil de cadastro: pagina > form > conclusao', 'Funil de conteudo: artigo > scroll 50% > CTA clicado', 'Funil de video: play > 50% > completo'] }
        ]
    },
    'funis.abandono': {
        suggestions: ['Carrinho abandonado', 'Checkout abandonado', 'Formulario incompleto', 'Session replay'],
        templates: [
            { label: 'Analise de abandono', items: ['Identificar etapa com maior drop-off', 'Heatmap: onde usuarios clicam e saem', 'Session replay: assistir sessoes', 'Remarketing: recuperar carrinhos'] }
        ]
    },
    'funis.otimizacao': {
        suggestions: ['Testes A/B', 'Reduzir etapas', 'Remover friccao', 'Urgencia', 'Prova social'],
        templates: [
            { label: 'Otimizacao de funil', items: ['Testar A/B: botao, copy, layout', 'Reduzir campos no formulario', 'Adicionar prova social', 'Elemento de urgencia', 'Monitorar impacto de cada mudanca'] }
        ]
    },
    'integracao.crm': {
        suggestions: ['HubSpot', 'Salesforce', 'RD Station', 'Pipedrive', 'API'],
        templates: [
            { label: 'Integracao CRM', items: ['Enviar leads do GA4/GTM para CRM', 'Sincronizar status: MQL, SQL, cliente', 'Rastrear LTV e CAC por canal'] }
        ]
    },
    'integracao.erp': {
        suggestions: ['Estoque', 'Pedidos', 'NF-e', 'Logistica', 'API'],
        templates: [
            { label: 'Integracao ERP', items: ['Sincronizar pedidos do site para ERP', 'Atualizar estoque em tempo real', 'Enviar dados de receita para GA4'] }
        ]
    },
    'integracao.apis': {
        suggestions: ['Measurement Protocol', 'Data API GA4', 'BigQuery', 'Webhooks', 'Zapier'],
        templates: [
            { label: 'Integracoes via API', items: ['GA4 Measurement Protocol: eventos server-side', 'Data API GA4: extrair dados para BI', 'BigQuery: exportar dados brutos', 'Zapier/Make: automacoes sem codigo'] }
        ]
    },
    'integracao.privacidade': {
        suggestions: ['LGPD', 'GDPR', 'Consentimento', 'Anonimizacao', 'Opt-out'],
        templates: [
            { label: 'Privacidade e compliance', items: ['Banner de consentimento (cookies)', 'GA4 consent mode', 'Permitir opt-out de rastreamento', 'Politica de privacidade atualizada'] }
        ]
    }
},

'ux-design': {
    'pesquisa.personas': {
        suggestions: ['Persona primaria', 'Persona secundaria', 'Usuario avancado', 'Usuario iniciante', 'Tomador de decisao'],
        templates: [
            { label: 'Persona Basica', items: ['Nome e idade ficticia da persona', 'Objetivo principal ao usar o produto', 'Principal dor ou frustacao', 'Comportamento tipico de navegacao', 'Dispositivo preferencial de acesso'] }
        ]
    },
    'pesquisa.jornada': {
        suggestions: ['Descoberta', 'Consideracao', 'Decisao', 'Pos-compra', 'Retencao'],
        templates: [
            { label: 'Jornada Completa', items: ['Usuario descobre o problema ou necessidade', 'Pesquisa por solucoes e alternativas', 'Compara opcoes e avalia beneficios', 'Toma a decisao de compra ou conversao', 'Usa o produto e avalia a experiencia'] }
        ]
    },
    'pesquisa.jtbd': {
        suggestions: ['Economizar tempo', 'Reduzir custos', 'Aumentar produtividade', 'Ganhar confianca', 'Simplificar processo'],
        templates: [
            { label: 'Framework JTBD', items: ['Quando [situacao], eu quero [motivacao]', 'Para que eu possa [resultado esperado]', 'Atualmente eu faco [solucao atual]', 'Mas isso [problema com solucao atual]'] }
        ]
    },
    'pesquisa.pesquisas': {
        suggestions: ['Entrevistas qualitativas', 'Questionario online', 'Teste de usabilidade', 'Analise de concorrentes', 'Pesquisa etnografica'],
        templates: [
            { label: 'Pesquisa Realizada', items: ['Tipo de pesquisa conduzida', 'Numero de participantes ou respostas', 'Principais insights descobertos', 'Data de realizacao e responsavel', 'Proximos passos ou acoes'] }
        ]
    },
    'navegacao.menu': {
        suggestions: ['Menu horizontal', 'Mega menu', 'Menu hamburguer', 'Menu sticky', 'Navegacao categorizada'],
        templates: [
            { label: 'Estrutura de Menu', items: ['Item de menu principal', 'Subitens ou categorias secundarias', 'Hierarquia e agrupamento logico', 'Links utilitarios (login, carrinho)', 'Comportamento em mobile'] }
        ]
    },
    'navegacao.hierarquia': {
        suggestions: ['Homepage', 'Categoria', 'Subcategoria', 'Pagina de produto', 'Pagina de detalhe'],
        templates: [
            { label: 'Niveis de Hierarquia', items: ['Nivel 1: Homepage e secoes principais', 'Nivel 2: Categorias de conteudo', 'Nivel 3: Subcategorias e filtros', 'Nivel 4: Paginas de detalhe ou produto', 'Maximo de cliques ate qualquer pagina'] }
        ]
    },
    'navegacao.breadcrumbs': {
        suggestions: ['Sempre visiveis', 'Com separadores', 'Links clicaveis', 'Mostrar categoria atual', 'Estruturados em schema'],
        templates: [
            { label: 'Regras de Breadcrumb', items: ['Exibir em todas as paginas exceto homepage', 'Formato: Home > Categoria > Subcategoria > Atual', 'Separador consistente (> ou /)', 'Ultimo item nao clicavel (pagina atual)', 'Marcacao schema.org/BreadcrumbList'] }
        ]
    },
    'navegacao.busca': {
        suggestions: ['Busca com autocomplete', 'Sugestoes em tempo real', 'Filtros avancados', 'Busca por voz', 'Historico de buscas'],
        templates: [
            { label: 'Config de Busca', items: ['Campo de busca visivel no header', 'Sugestoes enquanto o usuario digita', 'Resultados ordenados por relevancia', 'Filtros para refinar resultados', 'Pagina de resultados com alternativas'] }
        ]
    },
    'layout.grid': {
        suggestions: ['Grid de 12 colunas', 'Grid de 16 colunas', 'Grid modular', 'Espacamento consistente', 'Grid responsivo'],
        templates: [
            { label: 'Sistema de Grid', items: ['12 colunas com gutters de 20px', 'Container com max-width de 1200px', 'Breakpoints: mobile 320px, tablet 768px, desktop 1024px', 'Padding horizontal de 16px em mobile', 'Alinhamento centralizado do container'] }
        ]
    },
    'layout.visual': {
        suggestions: ['Titulo principal maior', 'Contraste de tamanhos', 'Peso de fonte', 'Espacamento estrategico', 'Cor para destaque'],
        templates: [
            { label: 'Hierarquia Visual', items: ['H1 principal com maior destaque visual', 'H2 para divisao de secoes importantes', 'H3 para subsecoes e agrupamentos', 'Texto de corpo legivel (16px minimo)', 'CTAs com cor contrastante e tamanho adequado'] }
        ]
    },
    'layout.responsividade': {
        suggestions: ['Mobile first', 'Tablet otimizado', 'Desktop fluido', 'Touch friendly', 'Imagens responsivas'],
        templates: [
            { label: 'Breakpoints Principais', items: ['Mobile: 320px a 767px (coluna unica)', 'Tablet: 768px a 1023px (2 colunas)', 'Desktop: 1024px+ (3 ou 4 colunas)', 'Menus colapsam em mobile (hamburguer)', 'Imagens com srcset para diferentes resolucoes'] }
        ]
    },
    'layout.whitespace': {
        suggestions: ['Espacamento generoso', 'Margem entre secoes', 'Padding interno', 'Line-height legivel', 'Respiro visual'],
        templates: [
            { label: 'Regras de Espacamento', items: ['Margem entre secoes de 60px a 80px', 'Padding interno de cards de 24px', 'Line-height de 1.6 para textos longos', 'Espacamento entre elementos relacionados menor', 'Espacamento entre grupos diferentes maior'] }
        ]
    },
    'componentes.botoes': {
        suggestions: ['Botao primario', 'Botao secundario', 'Botao de texto', 'Botao com icone', 'Estados de hover'],
        templates: [
            { label: 'Sistema de Botoes', items: ['Primario: preenchido, cor de destaque, para acao principal', 'Secundario: outline, para acoes alternativas', 'Altura minima de 44px para touch targets', 'Padding horizontal de 24px, vertical de 12px', 'Estados: default, hover, active, disabled, loading'] }
        ]
    },
    'componentes.formularios': {
        suggestions: ['Labels visiveis', 'Validacao inline', 'Mensagens de erro', 'Campos obrigatorios', 'Autocomplete habilitado'],
        templates: [
            { label: 'Padroes de Formulario', items: ['Label sempre visivel acima do campo', 'Placeholder como exemplo, nao como label', 'Validacao em tempo real apos blur do campo', 'Mensagem de erro abaixo do campo invalido', 'Botao de submit desabilitado ate formulario valido'] }
        ]
    },
    'componentes.cards': {
        suggestions: ['Card de produto', 'Card de artigo', 'Card de categoria', 'Card com imagem', 'Card clicavel'],
        templates: [
            { label: 'Anatomia do Card', items: ['Imagem ou thumbnail no topo', 'Titulo claro e descritivo', 'Descricao breve (2-3 linhas)', 'Meta informacoes (data, autor, categoria)', 'CTA ou link de acao ao final'] }
        ]
    },
    'componentes.modais': {
        suggestions: ['Modal centralizado', 'Overlay escuro', 'Botao de fechar', 'Foco no modal', 'Fechar com ESC'],
        templates: [
            { label: 'Comportamento de Modal', items: ['Abrir com transicao suave (fade in)', 'Overlay semi-transparente bloqueando fundo', 'Botao X no canto superior direito', 'Fechar ao clicar fora ou pressionar ESC', 'Foco automatico no primeiro campo ou botao'] },
            { label: 'Notificacoes Toast', items: ['Aparecer no canto superior direito', 'Auto-fechar apos 4-5 segundos', 'Tipos: sucesso (verde), erro (vermelho), info (azul)', 'Empilhar multiplas notificacoes', 'Botao para fechar manualmente'] }
        ]
    },
    'mobile.mobile_first': {
        suggestions: ['Projetar para mobile', 'Conteudo prioritario', 'Gestos nativos', 'Performance otimizada', 'Progressive enhancement'],
        templates: [
            { label: 'Abordagem Mobile-First', items: ['Criar design para mobile primeiro (320px)', 'Adicionar complexidade para telas maiores', 'Priorizar conteudo essencial em mobile', 'Usar progressive enhancement, nao graceful degradation', 'Testar em dispositivos reais, nao so emuladores'] }
        ]
    },
    'mobile.touch': {
        suggestions: ['44px minimo', 'Espacamento entre toques', 'Areas clicaveis grandes', 'Feedback visual', 'Evitar hover'],
        templates: [
            { label: 'Touch Targets', items: ['Tamanho minimo de 44x44px para elementos tocaveis', 'Espacamento de pelo menos 8px entre touch targets', 'Area clicavel maior que o elemento visual', 'Feedback visual imediato ao toque', 'Evitar interacoes que dependem de hover'] }
        ]
    },
    'mobile.perf_mobile': {
        suggestions: ['Imagens otimizadas', 'Lazy loading', 'Minificacao de assets', 'Cache agressivo', 'Reduzir requests'],
        templates: [
            { label: 'Otimizacoes Mobile', items: ['Imagens WebP com fallback, dimensoes otimizadas', 'Lazy loading de imagens e videos abaixo da dobra', 'Minificar CSS, JS e HTML', 'Service worker para cache de assets estaticos', 'Reduzir numero de requests HTTP ao minimo'] }
        ]
    },
    'mobile.nav_mobile': {
        suggestions: ['Menu hamburguer', 'Bottom navigation', 'Tab bar', 'Drawer lateral', 'Navegacao por gestos'],
        templates: [
            { label: 'Navegacao Mobile', items: ['Menu hamburguer com overlay full-screen', 'Itens principais com tamanho adequado para toque', 'Bottom tab bar para 3-5 secoes principais', 'Fechar menu ao selecionar item', 'Indicador visual do item ativo'] }
        ]
    },
    'testes.usabilidade': {
        suggestions: ['Teste com 5 usuarios', 'Tarefas especificas', 'Think aloud', 'Observacao direta', 'Teste remoto'],
        templates: [
            { label: 'Teste de Usabilidade', items: ['Recrutar 5 usuarios representativos', 'Preparar 3-5 tarefas especificas para completar', 'Pedir que usuario fale em voz alta (think aloud)', 'Observar dificuldades e pontos de confusao', 'Documentar insights e iterar no design'] }
        ]
    },
    'testes.ab': {
        suggestions: ['Testar CTA', 'Testar cores', 'Testar layout', 'Testar copy', 'Testar formulario'],
        templates: [
            { label: 'Hipotese A/B', items: ['Se mudarmos [elemento especifico]', 'Esperamos que [metrica] melhore', 'Porque [justificativa baseada em dados]', 'Vamos medir: [metrica primaria e secundarias]', 'Duracao do teste: [dias] ou [conversoes] minimas'] }
        ]
    },
    'testes.heatmaps': {
        suggestions: ['Hotjar', 'Microsoft Clarity', 'Crazy Egg', 'Mapa de cliques', 'Mapa de scroll'],
        templates: [
            { label: 'Analise de Heatmap', items: ['Configurar ferramenta (Hotjar, Clarity ou Crazy Egg)', 'Mapas de calor de cliques: identificar areas ignoradas', 'Mapas de scroll: ver ate onde usuarios rolam', 'Mapas de movimento: identificar padroes de leitura', 'Priorizar paginas com alto trafego e baixa conversao'] }
        ]
    },
    'testes.feedback': {
        suggestions: ['Pesquisa NPS', 'Widget de feedback', 'Formulario pos-uso', 'Email de feedback', 'Chat ao vivo'],
        templates: [
            { label: 'Canais de Feedback', items: ['Widget de feedback discreto no canto da tela', 'Pesquisa NPS pos-interacao importante', 'Email automatico pedindo feedback 3 dias apos compra', 'Formulario simples: "O que podemos melhorar?"', 'Chat ao vivo para suporte e coleta de feedback'] }
        ]
    }
},

'acessibilidade': {
    'semantica.headings': {
        suggestions: ['Ordem hierarquica', 'Um h1 por pagina', 'Nao pular niveis', 'Descritivos e claros', 'Estrutura logica'],
        templates: [
            { label: 'Hierarquia de Headings', items: ['Apenas um h1 por pagina (titulo principal)', 'Nao pular niveis (h1 > h2, nunca h1 > h3)', 'Ordem reflete estrutura visual do conteudo', 'Headings descrevem o conteudo que seguem', 'Usar h2-h6 para organizar secoes e subsecoes'] }
        ]
    },
    'semantica.landmarks': {
        suggestions: ['<header>', '<nav>', '<main>', '<aside>', '<footer>'],
        templates: [
            { label: 'Landmarks HTML5', items: ['<header> para cabecalho do site ou secao', '<nav> para navegacao principal e secundaria', '<main> para conteudo principal (unico por pagina)', '<aside> para conteudo relacionado ou complementar', '<footer> para rodape com informacoes secundarias'] }
        ]
    },
    'semantica.aria': {
        suggestions: ['aria-label', 'aria-labelledby', 'aria-describedby', 'aria-live', 'role'],
        templates: [
            { label: 'ARIA Basico', items: ['Usar aria-label para elementos sem texto visivel', 'aria-labelledby para associar label existente', 'aria-describedby para descricoes adicionais', 'aria-live para notificacoes dinamicas', 'role apenas quando semantica HTML nao for suficiente'] }
        ]
    },
    'semantica.listas': {
        suggestions: ['<ul> para nao ordenadas', '<ol> para ordenadas', '<dl> para definicoes', '<table> semantica', 'Listas aninhadas'],
        templates: [
            { label: 'Listas Semanticas', items: ['<ul> para itens sem ordem especifica (menu, features)', '<ol> para passos ordenados ou ranking', '<dl> para pares termo-definicao (glossario)', 'Nao usar listas apenas para layout/espacamento', 'Aninhar listas quando houver hierarquia'] }
        ]
    },
    'navegacao-a11y.tab_order': {
        suggestions: ['Ordem logica', 'tabindex natural', 'Evitar tabindex positivo', 'Elementos interativos', 'Formularios sequenciais'],
        templates: [
            { label: 'Tab Order Natural', items: ['Ordem de foco segue ordem visual da pagina', 'Elementos interativos recebiveis por Tab', 'Evitar tabindex com valores positivos (1, 2, 3...)', 'tabindex="0" para elementos customizados interativos', 'tabindex="-1" para remover do fluxo de teclado'] }
        ]
    },
    'navegacao-a11y.foco': {
        suggestions: ['Outline visivel', 'Contraste adequado', 'Nao remover outline', 'Estilos customizados', 'Focus-visible'],
        templates: [
            { label: 'Indicador de Foco', items: ['Nunca usar outline: none sem substituir por alternativa', 'Indicador visivel com contraste minimo de 3:1', 'Usar :focus-visible para navegacao por teclado', 'Estilo de foco consistente em todo o site', 'Offset de 2px entre elemento e indicador de foco'] }
        ]
    },
    'navegacao-a11y.skip': {
        suggestions: ['Skip to content', 'Skip to navigation', 'Primeiro elemento focavel', 'Visivel ao focar', 'Link interno'],
        templates: [
            { label: 'Skip Links', items: ['Primeiro elemento focavel da pagina', 'Texto: "Pular para o conteudo principal"', 'Oculto visualmente, visivel ao receber foco', 'Link ancora (#main-content) para elemento <main>', 'Considerar skip links para navegacao e formularios longos'] }
        ]
    },
    'navegacao-a11y.atalhos': {
        suggestions: ['Documentar atalhos', 'Evitar conflitos', 'Teclas comuns', 'Modal de ajuda', 'ESC para fechar'],
        templates: [
            { label: 'Atalhos de Teclado', items: ['ESC para fechar modais e overlays', 'Enter e Espaco para ativar botoes', 'Setas para navegacao em menus e carroseis', 'Evitar conflitos com atalhos do navegador', 'Fornecer lista de atalhos acessivel'] }
        ]
    },
    'visual.contraste': {
        suggestions: ['Minimo 4.5:1', 'Texto grande 3:1', 'Nivel AAA 7:1', 'Testar com ferramenta', 'Considerar daltonismo'],
        templates: [
            { label: 'Requisitos de Contraste', items: ['Texto normal: contraste minimo de 4.5:1 (WCAG AA)', 'Texto grande (18pt+): contraste minimo de 3:1', 'Nivel AAA: 7:1 para texto normal', 'Testar com ferramenta (WebAIM, axe DevTools)', 'Elementos de interface (botoes, bordas): 3:1 minimo'] }
        ]
    },
    'visual.texto': {
        suggestions: ['16px minimo', 'Line-height 1.5', 'Largura de linha', 'Fonte legivel', 'Zoom ate 200%'],
        templates: [
            { label: 'Texto Legivel', items: ['Tamanho minimo de 16px para corpo de texto', 'Line-height de 1.5 a 1.8 para textos longos', 'Largura maxima de linha: 70-80 caracteres', 'Fonte legivel (sans-serif para web)', 'Suportar zoom ate 200% sem quebra de layout'] }
        ]
    },
    'visual.cor': {
        suggestions: ['Icone + cor', 'Texto + cor', 'Padrao + cor', 'Sublinhado em links', 'Multiplos indicadores'],
        templates: [
            { label: 'Nao Depender de Cor', items: ['Links sublinhados alem de cor diferente', 'Mensagens de erro com icone + texto + cor vermelha', 'Campos obrigatorios com asterisco + cor', 'Status com icone + badge + cor', 'Graficos com padroes/texturas alem de cores'] }
        ]
    },
    'visual.preferencias': {
        suggestions: ['Modo escuro', 'Reducao de movimento', 'Alto contraste', 'Tamanho de fonte', 'Prefers-color-scheme'],
        templates: [
            { label: 'Preferencias do Usuario', items: ['Respeitar prefers-color-scheme (modo escuro/claro)', 'Respeitar prefers-reduced-motion (animacoes)', 'Oferecer toggle de modo escuro no site', 'Permitir ajuste de tamanho de fonte', 'Salvar preferencias em localStorage ou conta'] }
        ]
    },
    'midia.alt': {
        suggestions: ['Descritivo e conciso', 'Contexto relevante', 'Decorativas com alt vazio', 'Evitar "imagem de"', 'Alt em logos'],
        templates: [
            { label: 'Textos Alternativos', items: ['Descrever conteudo e funcao da imagem', 'Conciso (ate 125 caracteres ideal)', 'Imagens decorativas: alt="" (vazio, nao omitir)', 'Nao comecar com "imagem de" ou "foto de"', 'Logos: alt com nome da empresa/produto'] }
        ]
    },
    'midia.video': {
        suggestions: ['Legendas (captions)', 'Transcricao completa', 'Controles acessiveis', 'Autoplay desligado', 'Audio descricao'],
        templates: [
            { label: 'Videos Acessiveis', items: ['Legendas sincronizadas para audio', 'Transcricao textual completa disponivel', 'Controles de player acessiveis por teclado', 'Nunca autoplay com som', 'Considerar audio descricao para conteudo visual'] }
        ]
    },
    'midia.audiodesc': {
        suggestions: ['Descrever conteudo visual', 'Nas pausas naturais', 'Narrador profissional', 'Versao alternativa', 'Ativar/desativar'],
        templates: [
            { label: 'Audio Descricao', items: ['Descrever elementos visuais importantes nao falados', 'Inserir descricoes nas pausas naturais do audio', 'Narrador com voz clara e neutra', 'Fornecer como faixa alternativa ou arquivo separado', 'Usuario pode ativar/desativar conforme necessidade'] }
        ]
    },
    'midia.svg': {
        suggestions: ['role="img"', 'aria-label', '<title> no SVG', 'Icones decorativos', 'SVG inline acessivel'],
        templates: [
            { label: 'SVG Acessivel', items: ['role="img" e aria-label para SVGs com significado', '<title> como primeiro filho do <svg> inline', 'aria-hidden="true" para icones puramente decorativos', 'Garantir que cor nao seja unico indicador em graficos SVG', 'Fornecer alternativa textual para graficos complexos'] }
        ]
    },
    'formularios-a11y.labels': {
        suggestions: ['<label> sempre presente', 'for associado ao id', 'Instrucoes visiveis', 'Placeholder nao e label', 'Fieldset e legend'],
        templates: [
            { label: 'Labels de Formulario', items: ['Todo campo deve ter <label> visivelmente associado', 'Atributo for do label deve corresponder ao id do campo', 'Instrucoes importantes visiveis, nao apenas em placeholder', 'Placeholder como exemplo, nunca como substituto de label', 'Agrupar campos relacionados com <fieldset> e <legend>'] }
        ]
    },
    'formularios-a11y.erros': {
        suggestions: ['Mensagem descritiva', 'Associada ao campo', 'aria-describedby', 'aria-invalid', 'Foco no erro'],
        templates: [
            { label: 'Mensagens de Erro', items: ['Mensagem descritiva do problema e como corrigir', 'Associar erro ao campo com aria-describedby', 'Adicionar aria-invalid="true" ao campo com erro', 'Indicador visual (cor + icone + texto)', 'Mover foco para primeiro campo com erro apos submit'] }
        ]
    },
    'formularios-a11y.obrigatorios': {
        suggestions: ['aria-required', 'Asterisco + legenda', 'Indicador visual', 'Mensagem clara', 'required nativo'],
        templates: [
            { label: 'Campos Obrigatorios', items: ['Atributo required (HTML5) para validacao nativa', 'aria-required="true" para leitores de tela', 'Asterisco visual (*) no label + legenda no inicio', 'Mensagem: "Campos marcados com * sao obrigatorios"', 'Nao depender apenas de cor para indicar obrigatoriedade'] }
        ]
    },
    'formularios-a11y.autocomplete': {
        suggestions: ['autocomplete="name"', 'autocomplete="email"', 'autocomplete="tel"', 'Dados pessoais', 'Facilitacao'],
        templates: [
            { label: 'Autocomplete HTML', items: ['Usar atributo autocomplete adequado para cada campo', 'autocomplete="name" para nome completo', 'autocomplete="email" para email', 'autocomplete="tel" para telefone', 'autocomplete="address-line1" para endereco'] }
        ]
    },
    'conformidade.nivel': {
        suggestions: ['WCAG 2.1 AA', 'WCAG 2.1 AAA', 'WCAG 2.2 AA', 'Setor publico: AA', 'eMAG (Brasil)'],
        templates: [
            { label: 'Nivel WCAG', items: ['Meta: conformidade WCAG 2.1 nivel AA', 'AA e recomendacao padrao para sites comerciais', 'AAA para areas criticas (governo, saude, educacao)', 'Documentar criterios especificos', 'Revisar WCAG 2.2 para novos criterios'] }
        ]
    },
    'conformidade.ferramentas': {
        suggestions: ['axe DevTools', 'WAVE', 'Lighthouse', 'NVDA', 'VoiceOver'],
        templates: [
            { label: 'Ferramentas de Teste', items: ['axe DevTools (extensao) para auditoria automatizada', 'WAVE (WebAIM) para visualizar problemas na pagina', 'Lighthouse (Chrome DevTools) para score de acessibilidade', 'Leitores de tela: NVDA (Windows), VoiceOver (Mac/iOS)', 'Testes manuais com teclado (Tab, Enter, ESC, setas)'] }
        ]
    },
    'conformidade.testes_usuarios': {
        suggestions: ['Usuarios com deficiencia', 'Leitores de tela', 'Navegacao por teclado', 'Diversos contextos', 'Feedback direto'],
        templates: [
            { label: 'Testes com Usuarios', items: ['Recrutar usuarios com diferentes tipos de deficiencia', 'Observar uso real de leitores de tela', 'Testar navegacao exclusivamente por teclado', 'Incluir usuarios com daltonismo e baixa visao', 'Coletar feedback direto sobre barreiras encontradas'] }
        ]
    },
    'conformidade.declaracao': {
        suggestions: ['Nivel de conformidade', 'Data da avaliacao', 'Limitacoes conhecidas', 'Contato para feedback', 'Tecnologias usadas'],
        templates: [
            { label: 'Declaracao de Acessibilidade', items: ['Nivel de conformidade WCAG alcancado (A, AA, AAA)', 'Data da ultima avaliacao de acessibilidade', 'Limitacoes conhecidas e plano de correcao', 'Email ou formulario para relatar problemas', 'Tecnologias e ferramentas testadas'] }
        ]
    }
},

'conteudo': {
    'estrategia.objetivos': {
        suggestions: ['Gerar trafego organico', 'Educar o mercado', 'Gerar leads qualificados', 'Fortalecer autoridade', 'Nutrir relacionamento'],
        templates: [
            { label: 'Objetivos SMART', items: ['Especifico: aumentar trafego organico do blog', 'Mensuravel: de 5.000 para 15.000 visitas/mes', 'Atingivel: com 2 posts/semana + SEO', 'Relevante: gerar leads qualificados', 'Temporal: alcancar em 6 meses'] }
        ]
    },
    'estrategia.pillar': {
        suggestions: ['Guia completo', 'Pagina de recurso', 'Conteudo evergreen', 'Alta relevancia', 'Link para clusters'],
        templates: [
            { label: 'Pillar Page', items: ['Tema amplo e estrategico para o negocio', 'Conteudo abrangente (2000-4000 palavras)', 'Subdivido em topicos principais (subtopicos)', 'Links para topic clusters relacionados', 'Atualizado regularmente com novos insights'] }
        ]
    },
    'estrategia.clusters': {
        suggestions: ['Subtopico especifico', 'Palavra-chave long-tail', 'Link para pillar', 'Profundidade no tema', 'Conteudo focado'],
        templates: [
            { label: 'Topic Cluster', items: ['Subtopico especifico relacionado a pillar page', 'Palavra-chave long-tail com volume moderado', 'Conteudo focado (800-1500 palavras)', 'Link interno para pillar page e outros clusters', 'Responder duvidas especificas do usuario'] }
        ]
    },
    'estrategia.publico': {
        suggestions: ['Publico primario', 'Publico secundario', 'Influenciadores', 'Tomadores de decisao', 'Usuarios finais'],
        templates: [
            { label: 'Perfil de Publico', items: ['Quem sao: cargo, setor, tamanho da empresa', 'Objetivos e desafios enfrentados', 'Como consomem conteudo (formato, canal, horario)', 'Nivel de conhecimento (iniciante, intermediario, avancado)', 'Linguagem e tom adequados para esse publico'] }
        ]
    },
    'calendario.frequencia': {
        suggestions: ['Diaria', 'Semanal', 'Quinzenal', 'Mensal', 'Conforme demanda'],
        templates: [
            { label: 'Frequencia de Publicacao', items: ['Blog: 2 artigos por semana', 'Newsletter: toda segunda-feira', 'Video: 1 por semana (quintas)', 'Redes sociais: 1 post por dia', 'Materiais ricos: 1 por mes'] }
        ]
    },
    'calendario.pautas': {
        suggestions: ['Pauta sazonal', 'Pauta evergreen', 'Tendencia do mercado', 'Duvida de cliente', 'Case de sucesso'],
        templates: [
            { label: 'Banco de Pautas', items: ['Titulo provisorio da pauta', 'Palavra-chave principal e secundarias', 'Formato (artigo, video, ebook, infografico)', 'Publico-alvo e objetivo do conteudo', 'Data estimada de publicacao'] }
        ]
    },
    'calendario.fluxo': {
        suggestions: ['Ideacao', 'Aprovacao', 'Producao', 'Revisao', 'Publicacao'],
        templates: [
            { label: 'Fluxo de Producao', items: ['Ideacao e validacao da pauta (1-2 dias)', 'Pesquisa e outline (1 dia)', 'Redacao ou producao (2-3 dias)', 'Revisao e SEO (1 dia)', 'Design, programacao e publicacao (1 dia)'] }
        ]
    },
    'calendario.ferramentas': {
        suggestions: ['Trello', 'Asana', 'Notion', 'Planilha Google', 'Monday.com'],
        templates: [
            { label: 'Gestao de Conteudo', items: ['Ferramenta principal: Trello ou Notion', 'Quadro de calendario editorial com datas de publicacao', 'Colunas: Ideias > Aprovado > Em producao > Revisao > Publicado', 'Tags para tipo de conteudo e canal', 'Responsavel e prazo atribuidos a cada card'] }
        ]
    },
    'redacao.tom': {
        suggestions: ['Profissional e tecnico', 'Amigavel e acessivel', 'Inspiracional', 'Educativo', 'Informal e descontraido'],
        templates: [
            { label: 'Tom de Voz', items: ['Personalidade da marca: profissional mas acessivel', 'Linguagem: clara, direta, sem jargoes desnecessarios', 'Pessoa gramatical: 1a pessoa do plural (nos)', 'Tom emocional: confiante e encorajador', 'Exemplos de frases que seguem o tom definido'] }
        ]
    },
    'redacao.estrutura': {
        suggestions: ['Introducao', 'Desenvolvimento', 'Conclusao', 'H2 e H3', 'CTA ao final'],
        templates: [
            { label: 'Estrutura de Artigo', items: ['Introducao: problema ou contexto (1-2 paragrafos)', 'Desenvolvimento: topicos divididos em H2 e H3', 'Listas, exemplos e dados para apoiar argumentos', 'Conclusao: resumo e proximos passos', 'CTA final: oferta, download ou leitura relacionada'] }
        ]
    },
    'redacao.seo': {
        suggestions: ['Palavra-chave no titulo', 'Meta description', 'Headings hierarquicos', 'Links internos', 'Alt em imagens'],
        templates: [
            { label: 'SEO On-Page', items: ['Palavra-chave principal no H1 e nos primeiros 100 caracteres', 'Meta description com ate 155 caracteres e CTA', 'Uso de palavra-chave em H2 e ao longo do texto', 'Links internos para conteudo relacionado', 'Imagens otimizadas com alt descritivo'] }
        ]
    },
    'redacao.checklist': {
        suggestions: ['Revisao ortografica', 'Checagem de links', 'SEO completo', 'Imagens otimizadas', 'CTA presente'],
        templates: [
            { label: 'Checklist Pre-Publicacao', items: ['Revisao ortografica e gramatical', 'Todos os links funcionando (internos e externos)', 'SEO: titulo, meta description, headings, alt em imagens', 'Imagens comprimidas e responsivas', 'CTA claro e objetivo presente'] }
        ]
    },
    'formatos.blog': {
        suggestions: ['Tutorial passo a passo', 'Lista (X dicas)', 'Guia completo', 'Estudo de caso', 'Comparacao (X vs Y)'],
        templates: [
            { label: 'Tipos de Post', items: ['Tutorial: como fazer algo (passo a passo)', 'Lista: X dicas/ferramentas/estrategias', 'Guia: abordagem completa de um tema', 'Caso de sucesso: historia de cliente/resultado', 'Comparacao: diferenca entre solucoes ou abordagens'] }
        ]
    },
    'formatos.video': {
        suggestions: ['Tutorial em video', 'Entrevista', 'Webinar', 'Video curto (Reels)', 'Demonstracao de produto'],
        templates: [
            { label: 'Formatos de Video', items: ['Tutorial ou how-to (3-5 minutos)', 'Entrevista com especialista (10-15 minutos)', 'Webinar ou live (30-60 minutos)', 'Video curto para redes sociais (30-60 segundos)', 'Demo de produto ou feature (2-3 minutos)'] }
        ]
    },
    'formatos.ricos': {
        suggestions: ['Ebook', 'Whitepaper', 'Infografico', 'Checklist', 'Template'],
        templates: [
            { label: 'Materiais Ricos', items: ['Ebook: guia aprofundado (15-30 paginas, PDF)', 'Whitepaper: pesquisa ou estudo tecnico', 'Infografico: visualizacao de dados ou processo', 'Checklist: lista de verificacao pratica', 'Template: planilha ou documento editavel'] }
        ]
    },
    'formatos.podcast': {
        suggestions: ['Episodio solo', 'Entrevista com convidado', 'Painel de discussao', 'Podcast semanal', 'Audio transcrito'],
        templates: [
            { label: 'Podcast', items: ['Formato: episodios de 20-40 minutos', 'Cadencia: semanal ou quinzenal', 'Temas: entrevistas, analises, dicas praticas', 'Transcricao completa publicada no blog para SEO', 'Distribuicao: Spotify, Apple Podcasts, YouTube'] }
        ]
    },
    'distribuicao.canais': {
        suggestions: ['Blog proprio', 'LinkedIn', 'Instagram', 'YouTube', 'Newsletter'],
        templates: [
            { label: 'Canais de Distribuicao', items: ['Blog proprio (conteudo original e completo)', 'LinkedIn (artigos e posts profissionais)', 'Instagram (resumos visuais e stories)', 'YouTube (videos longos e tutoriais)', 'Newsletter (curadoria semanal de conteudo)'] }
        ]
    },
    'distribuicao.reaproveitamento': {
        suggestions: ['Post em carrossel', 'Video curto', 'Infografico', 'Thread no Twitter', 'Episodio de podcast'],
        templates: [
            { label: 'Reaproveitamento de Conteudo', items: ['Artigo original publicado no blog', 'Transformar em carrossel para LinkedIn/Instagram', 'Extrair trechos para threads no Twitter/X', 'Criar video curto resumindo pontos principais', 'Gravar episodio de podcast discutindo o tema'] }
        ]
    },
    'distribuicao.email': {
        suggestions: ['Newsletter semanal', 'Email de lancamento', 'Sequencia de nutricao', 'Resumo mensal', 'Email de conteudo'],
        templates: [
            { label: 'Estrategia de Email', items: ['Newsletter semanal com curadoria de conteudo', 'Email de lancamento para novos materiais ricos', 'Sequencia de nutricao pos-cadastro (5 emails)', 'Segmentacao por interesse ou estagio do funil', 'CTA claro em cada email (ler, baixar, agendar)'] }
        ]
    },
    'distribuicao.linkbuilding': {
        suggestions: ['Guest posts', 'Mencoes em midia', 'Parcerias', 'Conteudo de referencia', 'Digital PR'],
        templates: [
            { label: 'Link Building', items: ['Criar conteudo original de alta qualidade', 'Guest posts em sites relevantes do setor', 'Pitchs para jornalistas e blogs especializados', 'Parcerias com influenciadores e marcas complementares', 'Monitorar mencoes e solicitar links'] }
        ]
    },
    'metricas-conteudo.trafego': {
        suggestions: ['Visitas organicas', 'Sessoes por canal', 'Paginas mais visitadas', 'Taxa de rejeicao', 'Tempo na pagina'],
        templates: [
            { label: 'Metricas de Trafego', items: ['Visitas organicas mensais (Google Analytics)', 'Sessoes por canal (organico, direto, social, referral)', 'Top 10 paginas mais visitadas', 'Taxa de rejeicao por pagina', 'Tempo medio na pagina para conteudo chave'] }
        ]
    },
    'metricas-conteudo.engajamento': {
        suggestions: ['Tempo de leitura', 'Scroll depth', 'Comentarios', 'Compartilhamentos', 'Cliques em links'],
        templates: [
            { label: 'Metricas de Engajamento', items: ['Tempo medio de leitura por artigo', 'Scroll depth (% que rolam ate o fim)', 'Numero de comentarios e interacoes', 'Compartilhamentos em redes sociais', 'Taxa de cliques em CTAs e links internos'] }
        ]
    },
    'metricas-conteudo.conversao': {
        suggestions: ['Downloads de material', 'Formularios preenchidos', 'CTR de CTAs', 'Leads gerados', 'Valor por lead'],
        templates: [
            { label: 'Metricas de Conversao', items: ['Downloads de ebooks e materiais ricos', 'Formularios de contato preenchidos', 'Taxa de conversao (visitas > leads)', 'CTR de CTAs no conteudo', 'Atribuicao de receita a conteudos especificos'] }
        ]
    },
    'metricas-conteudo.rotina': {
        suggestions: ['Relatorio semanal', 'Analise mensal', 'Review trimestral', 'Dashboards ao vivo', 'Ajustes continuos'],
        templates: [
            { label: 'Rotina de Analise', items: ['Relatorio semanal de trafego e principais conteudos', 'Analise mensal de performance e ROI de conteudo', 'Review trimestral de estrategia e ajustes de pauta', 'Dashboard ao vivo (Data Studio ou similar)', 'Testes A/B continuos em titulos, CTAs e formatos'] }
        ]
    }
},

'cro': {
    'fundamentos.taxa_atual': {
        suggestions: ['2.5% desktop', '1.8% mobile', 'Por funil', 'Por canal', 'Por dispositivo'],
        templates: [
            { label: 'Baseline de Conversao', items: ['Taxa de conversao geral do site: 2.3%', 'Desktop: 3.1%, Mobile: 1.7%, Tablet: 2.0%', 'Por canal: Organico 2.8%, Pago 3.5%, Social 1.2%', 'Por pagina: Homepage 0.5%, Produto 4.2%, Checkout 68%', 'Calculo: (conversoes / sessoes) * 100'] }
        ]
    },
    'fundamentos.metas': {
        suggestions: ['Aumentar 30%', 'Meta trimestral', 'Meta anual', 'Meta por pagina', 'Meta por funil'],
        templates: [
            { label: 'Metas de Conversao', items: ['Meta geral: aumentar taxa de 2.3% para 3.5% em 6 meses', 'Meta por funil: dobrar conversao de visitante > lead', 'Meta por pagina: landing pages de 3% para 5%', 'Meta mobile: reduzir gap entre mobile e desktop', 'Timeline: revisar mensalmente e ajustar estrategia'] }
        ]
    },
    'fundamentos.micro_macro': {
        suggestions: ['Compra (macro)', 'Lead (macro)', 'Add to cart (micro)', 'Scroll (micro)', 'Video view (micro)'],
        templates: [
            { label: 'Conversoes Macro e Micro', items: ['Macro: compra, cadastro completo, solicitacao de orcamento', 'Micro: adicionar ao carrinho, assistir video, baixar material', 'Micro: scroll ate 75%, clicar em CTA, iniciar chat', 'Rastrear todas as micro-conversoes como eventos', 'Otimizar micro-conversoes para melhorar macro'] }
        ]
    },
    'fundamentos.framework': {
        suggestions: ['PIE Framework', 'ICE Score', 'Backlog priorizado', 'Hipoteses documentadas', 'Roadmap de testes'],
        templates: [
            { label: 'Framework PIE', items: ['Potential: quao grande e a oportunidade? (1-10)', 'Importance: quao importante e a pagina? (1-10)', 'Ease: quao facil e implementar? (1-10)', 'Score final: (P + I + E) / 3', 'Priorizar testes com maior score PIE'] }
        ]
    },
    'landing.headline': {
        suggestions: ['Beneficio claro', 'Proposta de valor', 'Acima da dobra', 'Destaque visual', 'Subheadline de apoio'],
        templates: [
            { label: 'Headline Eficaz', items: ['Beneficio principal em 5-10 palavras', 'Focada no usuario ("Voce" ou "Seu negocio")', 'Evitar jargoes e ser especifica', 'Subheadline complementa com detalhes ou prova', 'Acima da dobra, maior elemento textual'] }
        ]
    },
    'landing.estrutura': {
        suggestions: ['Hero section', 'Beneficios', 'Como funciona', 'Prova social', 'CTA final'],
        templates: [
            { label: 'Estrutura de Landing Page', items: ['Hero: headline + subheadline + CTA + imagem', 'Secao de beneficios: 3-5 principais vantagens', 'Como funciona: 3-4 passos simples', 'Prova social: depoimentos, logos, numeros', 'CTA final reforcado'] }
        ]
    },
    'landing.cta': {
        suggestions: ['Texto orientado a acao', 'Cor contrastante', 'Tamanho adequado', 'Acima da dobra', 'Repeticao estrategica'],
        templates: [
            { label: 'CTA Otimizado', items: ['Texto especifico: "Comece seu teste gratis" vs "Enviar"', 'Cor com alto contraste (A/B testar cores)', 'Tamanho minimo 44x44px, bem visivel', 'Primeiro CTA acima da dobra', 'Repetir CTA a cada 2-3 secoes de scroll'] }
        ]
    },
    'landing.confianca': {
        suggestions: ['Depoimentos com foto', 'Logos de clientes', 'Selos de seguranca', 'Garantias', 'Numeros e resultados'],
        templates: [
            { label: 'Elementos de Confianca', items: ['Depoimentos reais com foto, nome e cargo', 'Logos de empresas clientes conhecidas', 'Selos: SSL, PCI, premios, certificacoes', 'Garantia de satisfacao ou devolucao', 'Numeros: 10.000+ clientes, 4.9 estrelas'] }
        ]
    },
    'formularios-cro.campos': {
        suggestions: ['Nome e email apenas', 'CPF apenas se necessario', 'Formulario progressivo', 'Testar menos campos', 'Campos condicionais'],
        templates: [
            { label: 'Reducao de Campos', items: ['Quantos campos o formulario atual tem?', 'Teste: reduzir para apenas essenciais (nome + email)', 'Campos adicionais so se absolutamente necessarios', 'Considerar formulario progressivo (2 etapas)', 'Testar impacto de cada campo na conversao'] }
        ]
    },
    'formularios-cro.ux': {
        suggestions: ['Labels visiveis', 'Validacao inline', 'Auto-focus', 'Placeholder util', 'Teclado adequado'],
        templates: [
            { label: 'UX de Formulario', items: ['Labels sempre visiveis (nao desaparecem)', 'Validacao em tempo real ao sair do campo', 'Auto-focus no primeiro campo ao carregar', 'Placeholder como exemplo, nao como label', 'Input type adequado (email, tel) para mobile'] }
        ]
    },
    'formularios-cro.multistep': {
        suggestions: ['Dividir em etapas', 'Barra de progresso', 'Salvar rascunho', 'Logica condicional', 'Permitir voltar'],
        templates: [
            { label: 'Multi-Step Form', items: ['Dividir formularios longos em 2-4 etapas', 'Barra de progresso visivel (Etapa 1 de 3)', 'Permitir voltar sem perder dados', 'Auto-save de dados em localStorage', 'Campos condicionais: mostrar apenas se relevante'] }
        ]
    },
    'formularios-cro.sucesso': {
        suggestions: ['Confirmacao clara', 'Proximos passos', 'Upsell relevante', 'Compartilhamento', 'Tracking de conversao'],
        templates: [
            { label: 'Thank You Page', items: ['Confirmacao clara: "Seu pedido foi recebido!"', 'Proximos passos: "Voce recebera um email em 5 minutos"', 'Oferta complementar (upsell ou cross-sell)', 'Incentivo para compartilhar nas redes sociais', 'Tracking de conversao (GA, Facebook Pixel)'] }
        ]
    },
    'gatilhos.prova_social': {
        suggestions: ['Depoimentos reais', 'Avaliacoes 5 estrelas', 'Numero de clientes', 'Logos de empresas', 'Contador em tempo real'],
        templates: [
            { label: 'Prova Social', items: ['Depoimentos: foto + nome completo + cargo + empresa', 'Widget de avaliacoes (Trustpilot, Google Reviews)', 'Numeros: "Mais de 15.000 clientes satisfeitos"', 'Logos de empresas conhecidas que usam', 'Notificacoes: "Joao acabou de comprar"'] }
        ]
    },
    'gatilhos.urgencia': {
        suggestions: ['Contador regressivo', 'Estoque limitado', 'Vagas limitadas', 'Oferta por tempo', 'Urgencia honesta'],
        templates: [
            { label: 'Urgencia e Escassez', items: ['Contador regressivo para oferta (timer real)', 'Estoque: "Apenas 3 unidades restantes"', 'Vagas: "So 5 vagas disponiveis nesta turma"', 'IMPORTANTE: sempre ser honesto, nunca falsa urgencia', 'Testar presenca vs ausencia de urgencia'] }
        ]
    },
    'gatilhos.autoridade': {
        suggestions: ['Certificacoes', 'Premios recebidos', 'Mencoes na midia', 'Anos de experiencia', 'Especialistas'],
        templates: [
            { label: 'Autoridade', items: ['Certificacoes e acreditacoes relevantes', 'Premios da industria recebidos', 'Mencoes em midia conhecida (Forbes, Exame)', 'Anos de experiencia: "Desde 2010 no mercado"', 'Equipe de especialistas: fotos e credenciais'] }
        ]
    },
    'gatilhos.reciprocidade': {
        suggestions: ['Conteudo gratuito', 'Trial sem cartao', 'Garantia de reembolso', 'Amostra gratis', 'Risco zero'],
        templates: [
            { label: 'Reciprocidade e Garantia', items: ['Conteudo de valor gratuito (ebook, curso, ferramenta)', 'Trial de 14 dias sem exigir cartao de credito', 'Garantia de 30 dias de reembolso, sem perguntas', 'Amostras gratis ou freemium generoso', 'Politica de troca e devolucao flexivel'] }
        ]
    },
    'testes-cro.hipoteses': {
        suggestions: ['Testar cor de CTA', 'Testar headline', 'Testar formulario curto', 'Testar prova social', 'Testar imagens'],
        templates: [
            { label: 'Hipotese de Teste', items: ['Se mudarmos [elemento especifico]', 'Esperamos que [metrica] aumente', 'Porque [justificativa baseada em dados]', 'Vamos medir: CTR (primaria), conversoes (secundaria)', 'Teste durara 14 dias ou ate 1000 conversoes'] }
        ]
    },
    'testes-cro.ferramenta': {
        suggestions: ['Google Optimize', 'VWO', 'Optimizely', 'AB Tasty', 'Convert'],
        templates: [
            { label: 'Ferramenta de Teste', items: ['Ferramenta escolhida: Google Optimize (gratuito)', 'Integrado com Google Analytics para metricas', 'Configurar objetivos de conversao', 'Segmentacao: todos usuarios ou especifico', 'Variante A (controle) vs Variante B (tratamento)'] }
        ]
    },
    'testes-cro.processo': {
        suggestions: ['Duracao minima', 'Tamanho da amostra', 'Significancia 95%', 'Quando parar', 'Documentacao'],
        templates: [
            { label: 'Processo de Teste A/B', items: ['Duracao minima: 2 semanas ou 2 ciclos completos', 'Tamanho de amostra: minimo 100 conversoes por variante', 'Significancia estatistica: 95% de confianca', 'Nao parar o teste antes de alcancar significancia', 'Documentar hipotese, setup, resultados e aprendizados'] }
        ]
    },
    'testes-cro.historico': {
        suggestions: ['Teste vencedor', 'Teste perdedor', 'Sem resultado', 'Lift alcancado', 'Aprendizado chave'],
        templates: [
            { label: 'Registro de Teste', items: ['Data do teste e duracao', 'Hipotese testada', 'Resultado: vencedor com X% de lift', 'Significancia alcancada', 'Aprendizado e acao tomada'] }
        ]
    },
    'analise-cro.heatmaps': {
        suggestions: ['Hotjar', 'Microsoft Clarity', 'Crazy Egg', 'Mapa de cliques', 'Mapa de scroll'],
        templates: [
            { label: 'Analise de Heatmaps', items: ['Ferramenta: Hotjar ou Microsoft Clarity (gratuito)', 'Mapas de cliques: onde usuarios mais clicam', 'Mapas de scroll: ate onde rolam a pagina', 'Mapas de movimento: rastreamento do mouse', 'Priorizar: homepage, landing pages, checkout'] }
        ]
    },
    'analise-cro.gravacoes': {
        suggestions: ['Hotjar Recordings', 'Clarity', 'FullStory', 'Rage clicks', 'Pontos de confusao'],
        templates: [
            { label: 'Session Recordings', items: ['Gravar sessoes de usuarios reais', 'Observar padroes de comportamento e hesitacoes', 'Identificar rage clicks (cliques de frustracao)', 'Observar onde usuarios abandonam o funil', 'Revisar 20-30 sessoes por semana'] }
        ]
    },
    'analise-cro.pesquisas': {
        suggestions: ['Exit intent survey', 'NPS', 'Feedback pos-compra', 'Enquete rapida', 'O que te impediu'],
        templates: [
            { label: 'Pesquisas On-Site', items: ['Exit intent: "O que te impediu de comprar?"', 'NPS: "Qual a chance de recomendar?" (0-10)', 'Pesquisa pos-compra: "Como foi sua experiencia?"', 'Enquete: "Encontrou o que procurava?"', 'Ferramentas: Hotjar, Qualaroo, Typeform'] }
        ]
    },
    'analise-cro.auditoria': {
        suggestions: ['Velocidade', 'Mobile usability', 'Qualidade de copy', 'Clareza de CTAs', 'Objecoes respondidas'],
        templates: [
            { label: 'Checklist Auditoria CRO', items: ['Velocidade: LCP < 2.5s, FID < 100ms', 'Mobile: responsivo, botoes tocaveis, formularios simples', 'Copy: beneficios claros, sem jargoes, hierarquia visual', 'CTAs: texto de acao, contraste, posicionamento', 'Confianca: depoimentos, garantias, selos'] }
        ]
    }
},

'email-marketing': {
    'captacao.magnets': {
        suggestions: ['E-book gratuito', 'Checklist PDF', 'Template editavel', 'Mini-curso email', 'Desconto primeira compra', 'Trial gratuito'],
        templates: [
            { label: 'E-commerce', items: ['Cupom de 10% de desconto na primeira compra', 'Guia de tamanhos e medidas em PDF', 'Acesso antecipado a lancamentos e promocoes', 'Frete gratis na primeira compra'] },
            { label: 'Servicos', items: ['E-book com guia completo do nicho', 'Checklist de avaliacao gratuita', 'Consultoria de 30 minutos sem custo', 'Template de planejamento editavel'] }
        ]
    },
    'captacao.formularios': {
        suggestions: ['Pop-up exit intent', 'Formulario no header', 'Inline apos conteudo', 'Sidebar fixa', 'Footer expandido', 'Slide-in lateral'],
        templates: [
            { label: 'Formulario minimalista', items: ['Solicitar apenas email (sem nome)', 'CTA direto: "Quero receber"', 'Posicionar no final dos artigos', 'Design clean com foco na oferta'] }
        ]
    },
    'captacao.popups': {
        suggestions: ['Exit intent popup', 'Scroll 50% da pagina', 'Time delay 30s', 'Mobile friendly', 'A/B test variacoes'],
        templates: [
            { label: 'Estrategia de popups', items: ['Exit intent para visitantes novos', 'Nao exibir novamente por 7 dias', 'Versao mobile menos intrusiva', 'Testar 2 headlines diferentes', 'Frequencia cap: 1x por sessao'] }
        ]
    },
    'captacao.landing': {
        suggestions: ['Headline forte', 'Beneficios claros', 'Preview do material', 'Prova social', 'Formulario simples'],
        templates: [
            { label: 'Landing page de e-book', items: ['Headline com promessa especifica', 'Lista de 5-7 beneficios do material', 'Preview das primeiras paginas', 'Formulario com apenas email', 'Testemunhos de quem baixou'] }
        ]
    },
    'listas.segmentacao': {
        suggestions: ['Por interesse', 'Por comportamento', 'Por estagio funil', 'Por engajamento', 'Por localizacao', 'Por compra'],
        templates: [
            { label: 'Segmentacao e-commerce', items: ['Compradores vs nao-compradores', 'Frequencia de compra (1x, recorrente, VIP)', 'Categoria de produto preferida', 'Ticket medio (baixo, medio, alto)', 'Nivel de engajamento com emails'] }
        ]
    },
    'listas.tags': {
        suggestions: ['Lead magnet baixado', 'Pagina visitada', 'Produto comprado', 'Email aberto', 'Link clicado', 'Webinar assistido'],
        templates: [
            { label: 'Tags comportamentais', items: ['Tag por lead magnet especifico baixado', 'Tag por pagina de produto visitada', 'Tag por nivel de engajamento (ativo, morno, frio)', 'Tag por acoes realizadas (clique, compra, abandono)', 'Tag por interesse demonstrado'] }
        ]
    },
    'listas.higiene': {
        suggestions: ['Remover bounces', 'Limpar inativos', 'Campanha reativacao', 'Verificar emails', 'Limpeza trimestral'],
        templates: [
            { label: 'Rotina de limpeza', items: ['Remover hard bounces imediatamente', 'Campanha win-back para inativos 90+ dias', 'Remover quem nao abriu win-back apos 30 dias', 'Validacao de emails com ferramenta (ZeroBounce)', 'Revisao trimestral da lista completa'] }
        ]
    },
    'listas.lgpd': {
        suggestions: ['Double opt-in', 'Link descadastro', 'Politica privacidade', 'Consentimento claro', 'Registro de aceite'],
        templates: [
            { label: 'Conformidade LGPD', items: ['Implementar double opt-in obrigatorio', 'Link de descadastro visivel em todo email', 'Politica de privacidade linkada no formulario', 'Checkbox de consentimento explicito', 'Registro de data/hora/IP do consentimento'] }
        ]
    },
    'automacao.welcome': {
        suggestions: ['Email boas-vindas', 'Entrega do material', 'Historia da marca', 'Conteudo educativo', 'Primeira oferta'],
        templates: [
            { label: 'Sequencia 4 emails', items: ['Email 1 (imediato): entrega do lead magnet + boas-vindas', 'Email 2 (dia 2): apresentacao da marca e historia', 'Email 3 (dia 4): conteudo educativo de valor', 'Email 4 (dia 7): oferta suave com CTA claro'] }
        ]
    },
    'automacao.nurturing': {
        suggestions: ['Educar leads', 'Compartilhar cases', 'Demonstrar valor', 'Quebrar objecoes', 'Convite acao'],
        templates: [
            { label: 'Fluxo de nutricao', items: ['Conteudo educativo sobre o problema', 'Case de sucesso de cliente similar', 'Demonstracao de produto ou servico', 'Resposta as principais objecoes', 'Convite para demo ou consulta'] }
        ]
    },
    'automacao.carrinho': {
        suggestions: ['Lembrete 1h', 'Beneficios 24h', 'Urgencia 48h', 'Desconto final', 'Ultima chance'],
        templates: [
            { label: 'Recuperacao de carrinho', items: ['Email 1 (1h): lembrete gentil com imagem do produto', 'Email 2 (24h): beneficios e diferenciais do produto', 'Email 3 (48h): urgencia + desconto de 10%', 'Email 4 (96h): ultima chance para desconto'] }
        ]
    },
    'automacao.pos_venda': {
        suggestions: ['Confirmacao compra', 'Instrucoes uso', 'Pesquisa NPS', 'Pedir avaliacao', 'Cross-sell'],
        templates: [
            { label: 'Sequencia pos-compra', items: ['Confirmacao de pedido com expectativa de entrega', 'Instrucoes de uso e primeiros passos', 'Pesquisa de satisfacao (NPS) apos 7 dias', 'Solicitacao de avaliacao/depoimento', 'Recomendacao de produtos complementares'] }
        ]
    },
    'campanhas.newsletter': {
        suggestions: ['Semanal', 'Quinzenal', 'Mensal', 'Conteudo curado', 'Secoes fixas', 'Dia horario fixo'],
        templates: [
            { label: 'Newsletter semanal', items: ['Frequencia: toda terca-feira 10h', 'Secoes: artigo destaque, dica rapida, novidade', 'Mix: 70% conteudo educativo, 30% promocional', 'Design responsivo com largura maxima 600px', 'CTA claro em cada secao'] }
        ]
    },
    'campanhas.promocionais': {
        suggestions: ['Black Friday', 'Lancamento produto', 'Liquidacao', 'Datas comemorativas', 'Flash sale'],
        templates: [
            { label: 'Campanha Black Friday', items: ['Teaser 1 semana antes (criar expectativa)', 'Lancamento no dia (oferta principal)', 'Lembrete meio do periodo (urgencia)', 'Ultima chance 6h antes do fim', 'Agradecimento pos-campanha'] }
        ]
    },
    'campanhas.transacionais': {
        suggestions: ['Confirmacao pedido', 'Nota fiscal', 'Rastreamento', 'Reset senha', 'Boas-vindas'],
        templates: [
            { label: 'Emails transacionais', items: ['Design com branding da marca', 'Informacao principal em destaque', 'Oportunidade de cross-sell sutil no footer', 'Links uteis (FAQ, suporte, rastreamento)', 'Alta taxa de abertura: aproveitar para engajar'] }
        ]
    },
    'campanhas.templates': {
        suggestions: ['Template marca', 'Header com logo', 'Cores padrao', 'Layout responsivo', 'Botoes grandes'],
        templates: [
            { label: 'Template padrao', items: ['Header com logo e navegacao opcional', 'Largura maxima 600px para compatibilidade', 'Cores da marca com contraste acessivel', 'Botoes CTA grandes (minimo 44x44px)', 'Footer com links e descadastro'] }
        ]
    },
    'metricas-email.abertura': {
        suggestions: ['Open rate 20-25%', 'Subject line teste', 'Nome remetente', 'Pre-header otimizado', 'Hora de envio'],
        templates: [
            { label: 'Otimizar taxa de abertura', items: ['Testar diferentes subject lines (A/B test)', 'Usar nome de pessoa no remetente vs marca', 'Pre-header complementando o assunto', 'Enviar no melhor horario por segmento', 'Meta: open rate acima de 20%'] }
        ]
    },
    'metricas-email.ctr': {
        suggestions: ['CTR 2-5%', 'CTA claro', 'Posicao link', 'Heatmap cliques', 'CTOR'],
        templates: [
            { label: 'Melhorar CTR', items: ['CTA principal acima da dobra', 'Botao em cor de destaque', 'Multiplos CTAs para o mesmo link', 'Usar heatmap para otimizar posicionamento', 'Meta: CTR acima de 2.5%'] }
        ]
    },
    'metricas-email.conversao': {
        suggestions: ['Taxa conversao', 'Receita por email', 'ROI email', 'Automacao vs campanha', 'Lifetime value'],
        templates: [
            { label: 'Metricas de conversao', items: ['Rastrear conversoes via UTMs e eventos', 'Calcular receita por email enviado', 'Comparar ROI de automacoes vs campanhas', 'Medir lifetime value dos assinantes', 'Otimizar funil completo (email ate compra)'] }
        ]
    },
    'metricas-email.deliverability': {
        suggestions: ['Taxa entrega 95%+', 'Bounce rate baixo', 'Spam complaints', 'Reputacao dominio', 'Inbox placement'],
        templates: [
            { label: 'Monitorar entregabilidade', items: ['Manter bounce rate abaixo de 2%', 'Spam complaints abaixo de 0.1%', 'Monitorar reputacao com SenderScore', 'Verificar blacklists regularmente', 'Meta: deliverability acima de 95%'] }
        ]
    },
    'ferramentas-email.plataforma': {
        suggestions: ['Mailchimp', 'RD Station', 'ActiveCampaign', 'Brevo', 'ConvertKit', 'HubSpot'],
        templates: [
            { label: 'Escolha de ferramenta', items: ['Definir tamanho da lista e orcamento', 'Avaliar recursos (automacao, segmentacao, CRM)', 'Verificar integracoes disponiveis', 'Considerar suporte em portugues', 'Testar plano gratuito antes de contratar'] }
        ]
    },
    'ferramentas-email.autenticacao': {
        suggestions: ['SPF configurado', 'DKIM ativo', 'DMARC implementado', 'Dominio verificado', 'Teste MXToolbox'],
        templates: [
            { label: 'Autenticacao completa', items: ['Adicionar registro SPF no DNS', 'Configurar DKIM na plataforma de envio', 'Implementar politica DMARC', 'Verificar dominio no Business Manager', 'Testar com mail-tester.com'] }
        ]
    },
    'ferramentas-email.integracoes': {
        suggestions: ['Integracao site', 'CRM conectado', 'E-commerce sync', 'UTMs automaticos', 'Webhooks'],
        templates: [
            { label: 'Integracoes essenciais', items: ['Formularios do site sincronizados', 'CRM integrado (HubSpot, Pipedrive, RD)', 'E-commerce conectado (WooCommerce, Shopify)', 'UTMs automaticos em todos os links', 'Webhooks para eventos customizados'] }
        ]
    },
    'ferramentas-email.testes': {
        suggestions: ['A/B test subject', 'Teste renderizacao', 'Spam score', 'Preview clientes', 'Litmus'],
        templates: [
            { label: 'Checklist de testes', items: ['A/B test de subject line e CTA', 'Preview em principais clientes de email', 'Verificar spam score antes de enviar', 'Testar links e rastreamento', 'Enviar teste para equipe antes da campanha'] }
        ]
    }
},

'redes-sociais': {
    'estrategia-social.objetivos': {
        suggestions: ['Brand awareness', 'Gerar trafego', 'Captar leads', 'Vendas diretas', 'Relacionamento', 'Suporte cliente'],
        templates: [
            { label: 'Objetivos balanceados', items: ['Aumentar awareness da marca no nicho', 'Direcionar trafego qualificado para o site', 'Gerar leads atraves de conteudo', 'Fortalecer relacionamento com clientes', 'Suporte e atendimento via DM/comentarios'] }
        ]
    },
    'estrategia-social.plataformas': {
        suggestions: ['Instagram', 'TikTok', 'YouTube', 'LinkedIn', 'Facebook', 'Pinterest', 'Twitter/X'],
        templates: [
            { label: 'E-commerce B2C', items: ['Instagram: principal canal (feed + stories + reels)', 'TikTok: alcance organico e descoberta', 'Pinterest: produtos visuais e inspiracao', 'YouTube: tutoriais e reviews'] },
            { label: 'Servico B2B', items: ['LinkedIn: principal canal para autoridade', 'Instagram: humanizar a marca', 'YouTube: conteudo educativo longo', 'Twitter/X: networking e tendencias'] }
        ]
    },
    'estrategia-social.publico': {
        suggestions: ['Demografia definida', 'Interesses mapeados', 'Comportamento online', 'Dores identificadas', 'Horarios pico'],
        templates: [
            { label: 'Perfil de publico', items: ['Idade, genero, localizacao predominante', 'Principais interesses e hobbies', 'Tipo de conteudo que mais consome', 'Horarios de maior atividade online', 'Dores e aspiracoes do publico'] }
        ]
    },
    'estrategia-social.tom': {
        suggestions: ['Informal amigavel', 'Educativo tecnico', 'Inspiracional', 'Divertido leve', 'Profissional serio'],
        templates: [
            { label: 'Tom de voz consistente', items: ['Instagram: informal e inspirador', 'LinkedIn: profissional e educativo', 'TikTok: descontraido e autentifico', 'Evitar: sarcasmo, polemicas desnecessarias', 'Manter: positividade, empatia, clareza'] }
        ]
    },
    'instagram.perfil': {
        suggestions: ['Foto logo clara', 'Bio otimizada', 'Link na bio', 'Destaques organizados', 'Perfil comercial'],
        templates: [
            { label: 'Perfil otimizado', items: ['Foto: logo ou marca reconhecivel', 'Bio: O que faz + para quem + CTA', 'Link: Linktree ou pagina de links', 'Destaques: produtos, FAQ, bastidores, reviews', 'Perfil comercial com botoes de contato'] }
        ]
    },
    'instagram.feed': {
        suggestions: ['Identidade visual', 'Paleta cores', 'Templates prontos', 'Carrossel educativo', 'Grid harmonioso'],
        templates: [
            { label: 'Estrategia de feed', items: ['Paleta de 3-4 cores consistente', 'Templates no Canva para agilizar criacao', 'Mix: 40% carrossel, 30% imagem, 30% video', 'Proporcao: educativo, inspiracional, promocional', 'Grid harmonioso visualmente'] }
        ]
    },
    'instagram.stories_reels': {
        suggestions: ['Stories diarios', 'Stickers interativos', 'Reels com trends', 'Bastidores', 'Tutoriais rapidos'],
        templates: [
            { label: 'Stories e Reels', items: ['Stories: minimo 3x ao dia com stickers', 'Enquetes, quiz e caixinha de perguntas', 'Reels: 3-5x semana seguindo trends', 'Hook nos primeiros 3 segundos', 'Bastidores e making-of para humanizar'] }
        ]
    },
    'instagram.hashtags': {
        suggestions: ['5-15 hashtags', 'Mix volume', 'Nicho especifico', 'Trending tags', 'Hashtag marca'],
        templates: [
            { label: 'Estrategia de hashtags', items: ['3-5 hashtags grandes (100k+ posts)', '5-7 hashtags medias (10k-100k posts)', '3-5 hashtags nicho (menos de 10k)', 'Sempre incluir hashtag da marca', 'Legendas com CTA claro e emojis estrategicos'] }
        ]
    },
    'tiktok-youtube.tiktok': {
        suggestions: ['Trends atuais', 'Hook 3 segundos', 'Sons virais', 'Autenticidade', 'Post diario'],
        templates: [
            { label: 'Estrategia TikTok', items: ['Hook forte nos primeiros 3 segundos', 'Usar sons em alta (trending)', 'Videos de 15-30 segundos', 'Conteudo autentifico e descomplicado', 'Postar 1-2x ao dia para alcance'] }
        ]
    },
    'tiktok-youtube.youtube_longo': {
        suggestions: ['Roteiro estruturado', 'Thumbnail chamativa', 'Titulo com keyword', 'Descricao otimizada', 'End screen'],
        templates: [
            { label: 'Video longo otimizado', items: ['Roteiro com intro + conteudo + CTA', 'Thumbnail com texto grande e contraste', 'Titulo com keyword e curiosidade', 'Descricao com timestamps e links', 'End screens para outros videos'] }
        ]
    },
    'tiktok-youtube.shorts': {
        suggestions: ['Vertical 9:16', 'Reaproveitar Reels', 'Frequencia alta', 'CTA para longo', 'Serie recorrente'],
        templates: [
            { label: 'Estrategia Shorts', items: ['Reaproveitar Reels do Instagram', 'Postar 1-2 Shorts por dia', 'CTA sutil para canal ou video longo', 'Serie recorrente (ex: dica do dia)', 'Responder comentarios em video'] }
        ]
    },
    'tiktok-youtube.metricas_video': {
        suggestions: ['Retencao media', 'CTR thumbnail', 'Watch time', 'Engajamento', 'Fontes trafego'],
        templates: [
            { label: 'Metricas essenciais', items: ['Retencao: onde o publico abandona', 'CTR da thumbnail (acima de 5% e bom)', 'Watch time total do canal', 'Taxa de engajamento (likes, comentarios)', 'Fontes de trafego (busca, sugeridos, externo)'] }
        ]
    },
    'linkedin.company': {
        suggestions: ['Logo profissional', 'Descricao com keywords', 'Especializacoes', 'Funcionarios seguindo', 'Showcase pages'],
        templates: [
            { label: 'Company Page otimizada', items: ['Logo e capa profissionais atualizados', 'Descricao com keywords do setor', 'Adicionar especializacoes relevantes', 'Convidar todos os funcionarios para seguir', 'Criar showcase pages se multiplas linhas'] }
        ]
    },
    'linkedin.conteudo_li': {
        suggestions: ['Posts texto storytelling', 'Carrossel PDF', 'Artigos longos', 'Enquetes', 'Videos nativos'],
        templates: [
            { label: 'Mix de conteudo', items: ['Posts de texto com storytelling pessoal', 'Carrosseis PDF educativos (alta performance)', 'Artigos longos 1x semana (newsletter)', 'Enquetes para engajamento', 'Frequencia: 3-5x semana'] }
        ]
    },
    'linkedin.lideres': {
        suggestions: ['Perfil otimizado', 'Posts pessoais', 'Thought leadership', 'Social selling', 'Networking ativo'],
        templates: [
            { label: 'Personal branding', items: ['Perfil completo e otimizado com palavras-chave', 'Posts pessoais que reforcam valores da empresa', 'Compartilhar aprendizados e insights', 'Construir autoridade no setor', 'Conectar com clientes e parceiros estrategicos'] }
        ]
    },
    'linkedin.networking': {
        suggestions: ['Conexoes estrategicas', 'Grupos relevantes', 'Comentarios ativos', 'Mensagens personalizadas', 'Eventos online'],
        templates: [
            { label: 'Estrategia de networking', items: ['Conectar com clientes ideais e decisores', 'Participar de 3-5 grupos do nicho', 'Comentar em posts estrategicos diariamente', 'Mensagens de conexao personalizadas', 'Participar de eventos e lives LinkedIn'] }
        ]
    },
    'calendario-social.calendario': {
        suggestions: ['Frequencia definida', 'Horarios fixos', 'Temas por dia', 'Datas comemorativas', 'Sazonalidade'],
        templates: [
            { label: 'Calendario semanal', items: ['Instagram: feed 3x semana, stories diarios, reels 5x', 'LinkedIn: 3x semana (terca, quarta, sexta)', 'TikTok: 1-2x ao dia', 'Horarios: teste e ajuste por metrica', 'Calendario anual com datas importantes'] }
        ]
    },
    'calendario-social.pilares': {
        suggestions: ['Educativo', 'Bastidores', 'Produto', 'Depoimentos', 'Entretenimento', 'Inspiracional'],
        templates: [
            { label: '4 pilares de conteudo', items: ['Educativo 40%: dicas, tutoriais, guias', 'Bastidores 20%: equipe, processo, cultura', 'Produto 20%: lancamentos, features, beneficios', 'Depoimentos 10%: cases, reviews, UGC', 'Entretenimento 10%: memes, trends, leveza'] }
        ]
    },
    'calendario-social.ferramentas': {
        suggestions: ['mLabs', 'Hootsuite', 'Buffer', 'Meta Business Suite', 'Canva', 'CapCut', 'Notion'],
        templates: [
            { label: 'Stack de ferramentas', items: ['Agendamento: mLabs ou Meta Business Suite', 'Criacao: Canva Pro para posts e stories', 'Video: CapCut para edicao rapida', 'Planejamento: Notion ou Trello', 'Banco de ideias e conteudo pronto'] }
        ]
    },
    'calendario-social.processo': {
        suggestions: ['Brainstorm semanal', 'Batch content', 'Aprovacao clara', 'Agendamento antecipado', 'Engajamento diario'],
        templates: [
            { label: 'Processo semanal', items: ['Segunda: brainstorm e planejamento da semana', 'Terca: batch content (gravar/criar tudo)', 'Quarta: edicao e finalizacao', 'Quinta: aprovacao e agendamento', 'Diariamente: responder comentarios e DMs'] }
        ]
    },
    'integracao-site.opengraph': {
        suggestions: ['og:title', 'og:description', 'og:image 1200x630', 'Twitter Cards', 'Preview otimizado'],
        templates: [
            { label: 'Meta tags completas', items: ['og:title com titulo atrativo (max 60 caracteres)', 'og:description persuasiva (max 160 caracteres)', 'og:image em alta resolucao 1200x630px', 'og:type definido (website, article, product)', 'Testar preview com Facebook Debugger'] }
        ]
    },
    'integracao-site.share': {
        suggestions: ['Botoes visiveis', 'Posicao estrategica', 'Redes relevantes', 'Mobile friendly', 'Contador shares'],
        templates: [
            { label: 'Botoes de compartilhamento', items: ['Posicao: flutuante lateral ou no final do conteudo', 'Redes: WhatsApp, Facebook, Twitter, LinkedIn', 'Design: botoes grandes e reconheciveis', 'Mobile: barra fixa no rodape', 'Pre-preencher texto ao compartilhar'] }
        ]
    },
    'integracao-site.feed_site': {
        suggestions: ['Widget Instagram', 'Reviews Google', 'Feed tweets', 'Galeria UGC', 'Social proof'],
        templates: [
            { label: 'Feeds integrados', items: ['Widget de Instagram no footer ou homepage', 'Depoimentos do Google no rodape', 'Galeria de fotos de clientes (UGC)', 'Contador de seguidores das redes', 'Feed dinamico atualizado automaticamente'] }
        ]
    },
    'integracao-site.pixel': {
        suggestions: ['Meta Pixel', 'TikTok Pixel', 'LinkedIn Tag', 'Eventos rastreados', 'UTMs automaticos'],
        templates: [
            { label: 'Tracking completo', items: ['Meta Pixel instalado e verificado', 'TikTok Pixel para remarketing', 'LinkedIn Insight Tag para B2B', 'Eventos: PageView, ViewContent, AddToCart, Purchase', 'UTMs em todos os links da bio'] }
        ]
    }
},

'meta-ads': {
    'pixel-config.pixel': {
        suggestions: ['Via GTM', 'Codigo direto', 'Plugin WordPress', 'Pixel Helper', 'Events Manager'],
        templates: [
            { label: 'Instalacao completa', items: ['Instalar Pixel via Google Tag Manager', 'Adicionar codigo base em todas as paginas', 'Verificar instalacao no Events Manager', 'Instalar Pixel Helper no navegador', 'Testar eventos em tempo real'] }
        ]
    },
    'pixel-config.eventos': {
        suggestions: ['PageView', 'ViewContent', 'AddToCart', 'InitiateCheckout', 'Purchase', 'Lead'],
        templates: [
            { label: 'Eventos padrao', items: ['PageView automatico em todas as paginas', 'ViewContent em paginas de produto', 'AddToCart ao adicionar no carrinho', 'InitiateCheckout ao iniciar checkout', 'Purchase na pagina de confirmacao', 'Parametros: value, currency, content_ids'] }
        ]
    },
    'pixel-config.capi': {
        suggestions: ['Server-side tracking', 'Deduplicacao', 'Event ID unico', 'Gateway CAPI', 'Qualidade match'],
        templates: [
            { label: 'CAPI configurado', items: ['Configurar Conversions API server-side', 'Deduplicacao com Pixel via event_id', 'Enviar parametros de match (email, telefone, IP)', 'Integrar via GTM Server ou gateway', 'Meta: match quality acima de 6.0'] }
        ]
    },
    'pixel-config.dominio': {
        suggestions: ['Dominio verificado', '8 eventos priorizados', 'Aggregated events', 'iOS 14+ compliance'],
        templates: [
            { label: 'Configuracao iOS 14+', items: ['Verificar dominio no Business Manager', 'Priorizar 8 eventos mais importantes', 'Purchase como evento 1 (maior prioridade)', 'AddToCart, InitiateCheckout nos primeiros 4', 'Aggregated event measurement configurado'] }
        ]
    },
    'publicos.custom': {
        suggestions: ['Visitantes site', 'Lista clientes', 'Engajamento Instagram', 'Video viewers', 'Lead form'],
        templates: [
            { label: 'Publicos personalizados', items: ['Todos os visitantes do site (180 dias)', 'Visitantes das ultimas 30 e 60 dias', 'Lista de clientes (upload)', 'Engajamento no Instagram (90 dias)', 'Abandono de carrinho (nao compraram)'] }
        ]
    },
    'publicos.lookalike': {
        suggestions: ['LAL compradores', 'LAL top 25% clientes', '1% 2-5% 5-10%', 'Por pais', 'Valor vitalicio'],
        templates: [
            { label: 'Lookalikes estrategicos', items: ['LAL 1% baseado em compradores', 'LAL 1% dos top 25% clientes (LTV)', 'LAL 2-5% para escala', 'LAL 5-10% para topo de funil', 'Atualizar semente trimestralmente'] }
        ]
    },
    'publicos.interesses': {
        suggestions: ['Interesses nicho', 'Comportamentos compra', 'Demografia', 'Exclusoes precisas', 'Sobreposicao'],
        templates: [
            { label: 'Segmentacao por interesses', items: ['Testar interesses amplos vs especificos', 'Combinar interesses relacionados (OR)', 'Narrow audience com comportamento (AND)', 'Verificar sobreposicao de publicos (max 30%)', 'Excluir publicos nao-qualificados'] }
        ]
    },
    'publicos.exclusoes': {
        suggestions: ['Compradores recentes', 'Funcionarios', 'Publicos saturados', 'Janela 30 dias', 'Frequencia alta'],
        templates: [
            { label: 'Estrategia de exclusoes', items: ['Excluir compradores ultimos 30 dias (prospeccao)', 'Excluir funcionarios e parceiros', 'Excluir quem viu anuncio 3+ vezes sem converter', 'Criar publico de nao-compradores do carrinho', 'Ajustar janelas de exclusao por etapa do funil'] }
        ]
    },
    'estrutura-camp.objetivos': {
        suggestions: ['Vendas', 'Leads', 'Trafego', 'Engajamento', 'Awareness', 'Conversao otimizada'],
        templates: [
            { label: 'Quando usar cada objetivo', items: ['Vendas: e-commerce com catalogo e Purchase', 'Leads: captura de contatos (formulario ou landing)', 'Trafego: direcionar para site ou blog', 'Engajamento: aumentar seguidores e interacao', 'Awareness: alcance maximo com baixo CPM'] }
        ]
    },
    'estrutura-camp.conjuntos': {
        suggestions: ['CBO vs ABO', 'Por publico', 'Por funil', 'Nomenclatura padrao', 'Budget distribuido'],
        templates: [
            { label: 'Estrutura recomendada', items: ['Usar CBO (Campaign Budget Optimization)', 'Conjuntos separados por etapa do funil', 'Topo: interesses amplos e LAL 5-10%', 'Meio: LAL 1-2% e engajamento', 'Fundo: remarketing e carrinho abandonado'] }
        ]
    },
    'estrutura-camp.orcamento': {
        suggestions: ['CBO ativado', 'Diario vs vitalicio', 'Lowest cost', 'Bid cap', 'Cost cap', 'Escalonamento gradual'],
        templates: [
            { label: 'Estrategia de orcamento', items: ['Usar CBO para distribuicao automatica', 'Orcamento diario para melhor controle', 'Bid strategy: Lowest Cost para inicio', 'Cost Cap quando CPA estabilizar', 'Escalar 20% a cada 3 dias se CPA ok'] }
        ]
    },
    'estrutura-camp.nomenclatura': {
        suggestions: ['Prefixo objetivo', 'Nome publico', 'Formato anuncio', 'Data inicio', 'Filtros faceis'],
        templates: [
            { label: 'Padrao de nomenclatura', items: ['Campanha: [VENDAS]_[Q1-2025]_[E-commerce]', 'Conjunto: [VENDAS]_[LAL-Compradores-1%]_[Carrossel]', 'Anuncio: [VENDAS]_[LAL-1%]_[Carrossel]_[CTA-Compre]_[v1]', 'Facilita analise, filtros e relatorios', 'Incluir versao do criativo (v1, v2, v3)'] }
        ]
    },
    'criativos.formatos': {
        suggestions: ['Imagem unica', 'Carrossel', 'Video 15-30s', 'Reels ads', 'Stories ads', 'Collection'],
        templates: [
            { label: 'Quando usar cada formato', items: ['Imagem unica: oferta simples, teste rapido', 'Carrossel: mostrar variedade de produtos', 'Video curto: demonstracao, storytelling', 'Reels/Stories: conteudo nativo, UGC style', 'Collection: catalogo de produtos'] }
        ]
    },
    'criativos.copies': {
        suggestions: ['Gancho forte', 'Problema-solucao', 'Prova social', 'CTA claro', 'Emojis estrategicos'],
        templates: [
            { label: 'Estrutura de copy', items: ['Gancho: pergunta ou afirmacao curiosa', 'Problema: dor ou frustracao do publico', 'Solucao: como o produto resolve', 'Prova: depoimento, numero, garantia', 'CTA: acao clara (Compre, Saiba mais)'] }
        ]
    },
    'criativos.visuais': {
        suggestions: ['Pouco texto imagem', 'Cor chamativa', 'Rosto humano', 'Before/after', 'UGC style', 'Mockup'],
        templates: [
            { label: 'Regras de criativo', items: ['Minimo de texto na imagem (max 20%)', 'Usar cores contrastantes com feed', 'Incluir rosto humano aumenta CTR', 'Before/after para transformacao', 'UGC style (celular, autentifico) performa bem'] }
        ]
    },
    'criativos.testes_criativo': {
        suggestions: ['DCT ativo', '3-5 variacoes', 'Isolar variaveis', 'CTR e CPA', 'Vencedor escala'],
        templates: [
            { label: 'Processo de teste', items: ['Usar Dynamic Creative Testing (DCT)', 'Testar 3-5 variacoes simultaneas', 'Isolar variaveis: testar imagem OU copy', 'Metricas: CTR > 2% e CPA < meta', 'Escalar vencedores com novo publico'] }
        ]
    },
    'otimizacao-ads.kpis': {
        suggestions: ['CPM', 'CTR', 'CPA', 'ROAS', 'Frequencia', 'Hook rate', 'Hold rate'],
        templates: [
            { label: 'KPIs por objetivo', items: ['Awareness: CPM, alcance, frequencia', 'Trafego: CTR, CPC, bounce rate', 'Conversao: CPA, taxa conversao, ROAS', 'Video: hook rate (3s views), hold rate', 'Frequencia ideal: 1.5-2.5'] }
        ]
    },
    'otimizacao-ads.diaria': {
        suggestions: ['Verificar CPA', 'Pausar ads fracos', 'Escalar vencedores', 'Monitorar frequencia', 'Ajustar budget'],
        templates: [
            { label: 'Rotina diaria', items: ['Verificar CPA vs meta definida', 'Pausar ads com CPA 2x acima da meta', 'Aumentar budget em ads com ROAS alto', 'Monitorar frequencia (pausar se > 3.5)', 'Revisar novos comentarios nos ads'] }
        ]
    },
    'otimizacao-ads.escala': {
        suggestions: ['Aumento gradual 20%', 'Duplicar conjuntos', 'Novos publicos', 'Horizontal scaling', 'Vertical scaling'],
        templates: [
            { label: 'Escalar sem perder performance', items: ['Vertical: aumentar budget 20% a cada 3 dias', 'Horizontal: duplicar conjunto com novo publico', 'Expandir para LAL maiores (1% > 2-5%)', 'Adicionar novos placements gradualmente', 'Nao escalar se CPA ainda instavel'] }
        ]
    },
    'otimizacao-ads.diagnostico': {
        suggestions: ['CPM alto', 'CTR baixo', 'CPA alto', 'Queda performance', 'Fadiga anuncio'],
        templates: [
            { label: 'Resolver problemas', items: ['CPM alto: publico saturado > trocar publico', 'CTR baixo: criativo fraco > testar novos visuais', 'CPA alto: landing ruim > otimizar LP', 'Queda de performance: fadiga > trocar criativos', 'Frequencia alta: publico pequeno > expandir'] }
        ]
    },
    'remarketing.funil': {
        suggestions: ['Visitou site', 'Visualizou produto', 'Carrinho abandonado', 'Iniciou checkout', 'Janelas tempo'],
        templates: [
            { label: 'Funil de remarketing', items: ['Topo: visitou site mas nao viu produto (30 dias)', 'Meio: visualizou produto mas nao adicionou (14 dias)', 'Fundo: adicionou ao carrinho mas nao comprou (7 dias)', 'Ultra-fundo: iniciou checkout mas nao finalizou (3 dias)', 'Budget: 60% fundo, 30% meio, 10% topo'] }
        ]
    },
    'remarketing.sequencia': {
        suggestions: ['Lembrete produto', 'Beneficios', 'Prova social', 'Urgencia desconto', 'Ultima chance'],
        templates: [
            { label: 'Sequencia de remarketing', items: ['Dia 1-3: lembrete do produto visualizado', 'Dia 4-7: beneficios e diferenciais', 'Dia 8-14: depoimentos e prova social', 'Dia 15-30: desconto especial + urgencia', 'Criativo diferente em cada fase'] }
        ]
    },
    'remarketing.crosssell': {
        suggestions: ['Produtos complementares', 'Upgrades', 'Novidades', 'Lancamentos', 'Programa fidelidade'],
        templates: [
            { label: 'Remarketing para compradores', items: ['Publico: compraram nos ultimos 30 dias', 'Oferecer produtos complementares', 'Upgrade ou versao premium', 'Lancamentos e novidades', 'Programa de indicacao ou fidelidade'] }
        ]
    },
    'remarketing.dpa': {
        suggestions: ['Catalogo configurado', 'Feed atualizado', 'Template dinamico', 'Segmentacao comportamento', 'Cross-sell automatico'],
        templates: [
            { label: 'Dynamic Product Ads', items: ['Catalogo de produtos atualizado diariamente', 'Feed otimizado (titulo, imagem, preco)', 'Template de anuncio dinamico criado', 'Remarketing por produto visualizado', 'Exclusao de produtos sem estoque'] }
        ]
    }
},

'infraestrutura': {
    'hospedagem.tipo': {
        suggestions: ['Compartilhada', 'VPS', 'Cloud AWS', 'Dedicado', 'Managed WordPress'],
        templates: [
            { label: 'Sites pequenos/medios', items: ['Hospedagem compartilhada para MVP ou site simples', 'Managed WordPress (Kinsta, WP Engine) para WordPress', 'VPS quando precisar mais controle e recursos', 'Considerar trafego mensal e tipo de site'] },
            { label: 'Sites grandes', items: ['Cloud (AWS, GCP, DigitalOcean) para escalabilidade', 'Load balancer para distribuir carga', 'Auto-scaling em picos de trafego', 'CDN global para performance'] }
        ]
    },
    'hospedagem.provedor': {
        suggestions: ['HostGator Brasil', 'Hostinger', 'AWS', 'DigitalOcean', 'Kinsta', 'Cloudways'],
        templates: [
            { label: 'Escolha do provedor', items: ['Provedor contratado e plano especifico', 'Recursos: CPU, RAM, armazenamento SSD', 'Localizacao do datacenter (Brasil ou EUA)', 'Suporte em portugues e SLA garantido', 'Custo mensal e forma de pagamento'] }
        ]
    },
    'hospedagem.escalabilidade': {
        suggestions: ['Auto-scaling', 'Load balancer', 'CDN', 'Cache server', 'Plano contingencia'],
        templates: [
            { label: 'Plano de escalabilidade', items: ['Configurar auto-scaling para picos de trafego', 'Implementar CDN (Cloudflare) para cache global', 'Load balancer se multiplos servidores', 'Plano de upgrade quando atingir 70% capacidade', 'Monitorar recursos semanalmente'] }
        ]
    },
    'hospedagem.painel': {
        suggestions: ['cPanel', 'Plesk', 'Painel customizado', 'SSH', 'FTP/SFTP', 'phpMyAdmin'],
        templates: [
            { label: 'Acessos e painel', items: ['Painel de controle: cPanel ou Plesk', 'Acesso SSH para linha de comando', 'FTP/SFTP para upload de arquivos', 'phpMyAdmin para gerenciar banco de dados', 'Documentar usuarios e permissoes'] }
        ]
    },
    'dominio.registro': {
        suggestions: ['Registro.br', 'GoDaddy', 'Cloudflare', 'Namecheap', 'Auto-renovacao'],
        templates: [
            { label: 'Gestao de dominios', items: ['Dominio principal: seusite.com.br', 'Dominios secundarios: .com, .com.br', 'Registrador: Registro.br ou GoDaddy', 'Auto-renovacao ativada', 'WHOIS privacy protection ativo'] }
        ]
    },
    'dominio.dns': {
        suggestions: ['Registro A', 'CNAME', 'MX records', 'TXT SPF', 'Cloudflare DNS', 'TTL baixo'],
        templates: [
            { label: 'Configuracao DNS', items: ['Nameservers apontando para Cloudflare ou provedor', 'Registro A para dominio principal', 'CNAME para www apontando para dominio', 'Registros MX para email profissional', 'TXT para SPF, DKIM, DMARC'] }
        ]
    },
    'dominio.subdominios': {
        suggestions: ['www', 'blog', 'app', 'api', 'staging', 'mail'],
        templates: [
            { label: 'Subdominios em uso', items: ['www.seusite.com.br (principal)', 'blog.seusite.com.br (WordPress separado)', 'app.seusite.com.br (aplicacao web)', 'api.seusite.com.br (API REST)', 'SSL/TLS configurado para cada subdominio'] }
        ]
    },
    'dominio.redirecionamentos': {
        suggestions: ['301 permanente', 'www vs non-www', 'HTTP para HTTPS', '.htaccess', 'Nginx config'],
        templates: [
            { label: 'Redirecionamentos essenciais', items: ['Redirecionar non-www para www (ou vice-versa)', 'Forcar HTTPS em todas as paginas', 'Redirecionar dominios antigos (301)', 'Configurar via .htaccess ou Nginx', 'Testar todos os redirecionamentos'] }
        ]
    },
    'ssl-seguranca.ssl': {
        suggestions: ['Let\'s Encrypt gratuito', 'DV SSL', 'OV SSL', 'Wildcard', 'Renovacao automatica'],
        templates: [
            { label: 'Certificado SSL', items: ['Tipo: Let\'s Encrypt (gratuito e confiavel)', 'Renovacao automatica a cada 90 dias', 'Instalado em dominio e subdominios', 'Verificar cadeado verde no navegador', 'Testar com SSL Labs (nota A ou A+)'] }
        ]
    },
    'ssl-seguranca.headers': {
        suggestions: ['HSTS', 'X-Content-Type-Options', 'X-Frame-Options', 'CSP', 'Referrer-Policy'],
        templates: [
            { label: 'Security headers', items: ['HSTS: forcar HTTPS por 1 ano', 'X-Content-Type-Options: nosniff', 'X-Frame-Options: SAMEORIGIN ou DENY', 'Content-Security-Policy configurado', 'Testar com securityheaders.com'] }
        ]
    },
    'ssl-seguranca.firewall': {
        suggestions: ['Cloudflare WAF', 'Sucuri', 'ModSecurity', 'DDoS protection', 'Rate limiting'],
        templates: [
            { label: 'Firewall e protecao', items: ['WAF ativo (Cloudflare ou Sucuri)', 'Regras contra SQL injection e XSS', 'Protecao DDoS no nivel de rede', 'Rate limiting: max 100 requests/min por IP', 'Monitoramento de tentativas de invasao'] }
        ]
    },
    'ssl-seguranca.atualizacoes': {
        suggestions: ['PHP atualizado', 'MySQL/MariaDB', 'WordPress core', 'Plugins atualizados', 'Sistema operacional'],
        templates: [
            { label: 'Politica de atualizacao', items: ['PHP na versao estavel mais recente (8.x)', 'MySQL/MariaDB atualizado', 'WordPress core atualizado automaticamente', 'Plugins atualizados semanalmente', 'Testar em staging antes de producao'] }
        ]
    },
    'email-prof.provedor_email': {
        suggestions: ['Google Workspace', 'Microsoft 365', 'Zoho Mail', 'Email no servidor', 'Titan Email'],
        templates: [
            { label: 'Email profissional', items: ['Provedor: Google Workspace ou Microsoft 365', 'Plano Business Standard (50GB por usuario)', 'Numero de contas criadas', 'Custo mensal por usuario', 'Suporte 24/7 incluso'] }
        ]
    },
    'email-prof.contas': {
        suggestions: ['contato@', 'suporte@', 'vendas@', 'financeiro@', 'Aliases', 'Grupos'],
        templates: [
            { label: 'Contas de email', items: ['contato@seusite.com.br (geral)', 'suporte@seusite.com.br (atendimento)', 'vendas@seusite.com.br (comercial)', 'financeiro@seusite.com.br (cobranca)', 'Grupos de distribuicao para equipes'] }
        ]
    },
    'email-prof.autenticacao_email': {
        suggestions: ['SPF record', 'DKIM', 'DMARC', 'MXToolbox', 'Mail-tester'],
        templates: [
            { label: 'Autenticacao completa', items: ['Registro SPF no DNS', 'DKIM configurado e verificado', 'DMARC com politica quarantine ou reject', 'Testar com mail-tester.com (score 10/10)', 'Verificar MX records com MXToolbox'] }
        ]
    },
    'email-prof.assinatura': {
        suggestions: ['Template padrao', 'Nome cargo telefone', 'Logo empresa', 'Links sociais', 'Banner promocional'],
        templates: [
            { label: 'Assinatura de email', items: ['Template HTML padrao da empresa', 'Nome completo, cargo, telefone', 'Logo da empresa (max 150px)', 'Links para redes sociais', 'Ferramenta: WiseStamp ou Exclaimer'] }
        ]
    },
    'backup.estrategia': {
        suggestions: ['Regra 3-2-1', 'Arquivos completos', 'Banco de dados', 'Emails', 'Configuracoes'],
        templates: [
            { label: 'Estrategia 3-2-1', items: ['3 copias dos dados (producao + 2 backups)', '2 midias diferentes (servidor + cloud)', '1 copia offsite (fora do servidor)', 'Backup completo semanal + incremental diario', 'Criptografia dos backups'] }
        ]
    },
    'backup.frequencia': {
        suggestions: ['Diario automatico', 'Retencao 30 dias', 'Antes atualizacoes', 'Manual sob demanda', 'Retencao 90 dias'],
        templates: [
            { label: 'Frequencia e retencao', items: ['Backup automatico diario as 3h da manha', 'Retencao: 30 dias de backups diarios', 'Retencao: 12 semanas de backups semanais', 'Backup manual antes de qualquer atualizacao', 'Alerta se backup falhar'] }
        ]
    },
    'backup.armazenamento': {
        suggestions: ['S3 bucket', 'Google Cloud Storage', 'Backup local', 'Dropbox Business', 'Criptografia AES'],
        templates: [
            { label: 'Onde ficam os backups', items: ['Cloud storage: AWS S3 ou Google Cloud', 'Backup local em servidor separado', 'Criptografia AES-256 em todos os backups', 'Acesso restrito apenas a administradores', 'Regiao de armazenamento (compliance)'] }
        ]
    },
    'backup.restauracao': {
        suggestions: ['Teste trimestral', 'Ambiente staging', 'RTO definido', 'RPO definido', 'Documentacao processo'],
        templates: [
            { label: 'Teste de restauracao', items: ['Testar restore completo trimestralmente', 'Ambiente de staging para teste seguro', 'RTO (tempo de recuperacao): 4 horas', 'RPO (ponto de recuperacao): max 24h', 'Documentar passo a passo do restore'] }
        ]
    },
    'deploy.ambientes': {
        suggestions: ['Local dev', 'Staging', 'Producao', 'URLs separadas', 'Dados anonimizados'],
        templates: [
            { label: 'Ambientes configurados', items: ['Desenvolvimento: local (localhost)', 'Staging: staging.seusite.com.br', 'Producao: seusite.com.br (publico)', 'Dados de staging anonimizados', 'Acesso staging protegido por senha'] }
        ]
    },
    'deploy.git': {
        suggestions: ['GitHub', 'GitLab', 'Bitbucket', 'GitFlow', 'Pull requests', 'Code review'],
        templates: [
            { label: 'Versionamento com Git', items: ['Repositorio Git no GitHub ou GitLab', 'Branching: GitFlow ou trunk-based', 'Branch main/master protegida', 'Pull requests obrigatorios', 'Code review antes de merge'] }
        ]
    },
    'deploy.cicd': {
        suggestions: ['GitHub Actions', 'GitLab CI', 'Jenkins', 'Build automatico', 'Testes automatizados', 'Rollback'],
        templates: [
            { label: 'Pipeline CI/CD', items: ['Ferramenta: GitHub Actions ou GitLab CI', 'Pipeline: build > testes > deploy', 'Deploy automatico em staging ao fazer merge', 'Deploy em producao com aprovacao manual', 'Rollback automatico se testes falharem'] }
        ]
    },
    'deploy.monitoramento': {
        suggestions: ['UptimeRobot', 'Pingdom', 'Alertas Slack', 'New Relic APM', 'Status page', 'Logs erro'],
        templates: [
            { label: 'Monitoramento pos-deploy', items: ['Uptime monitoring: UptimeRobot ou Pingdom', 'Alertas por email/SMS/Slack se site cair', 'Monitorar logs de erro apos deploy', 'APM (New Relic ou Datadog) para performance', 'Verificar metricas 24h apos deploy'] }
        ]
    }
},

estrutura: {
    'arquitetura.mapa_site': {
        suggestions: ['Home', 'Sobre', 'Servicos', 'Contato', 'Blog', 'Produtos', 'Portfolio', 'FAQ'],
        templates: [
            { label: 'Site Institucional', items: ['Home', 'Sobre Nos', 'Servicos', 'Portfolio', 'Blog', 'Contato'] },
            { label: 'E-commerce', items: ['Home', 'Produtos', 'Categorias', 'Carrinho', 'Minha Conta', 'Contato'] }
        ]
    },
    'arquitetura.hierarquia': {
        suggestions: ['Nivel 1: Home', 'Nivel 2: Categorias', 'Nivel 3: Produtos', 'Breadcrumb ativo'],
        templates: [
            { label: 'Hierarquia Padrao', items: ['Home (nivel 1)', 'Secoes principais (nivel 2)', 'Subsecoes (nivel 3)', 'Paginas de conteudo (nivel 4)'] }
        ]
    },
    'arquitetura.urls': {
        suggestions: ['/categoria/subcategoria', '/blog/titulo-post', '/produto/nome-produto', 'Minusculas com hifen'],
        templates: [
            { label: 'URL Amigavel', items: ['Usar hifens em vez de underscores', 'Minusculas apenas', 'Sem acentuacao', 'Maximo 60 caracteres', 'Incluir palavra-chave'] }
        ]
    },
    'arquitetura.navegacao': {
        suggestions: ['Home para Produtos', 'Produtos para Checkout', 'Blog para Post', 'Header fixo'],
        templates: [
            { label: 'Fluxo de Conversao', items: ['Home: apresentacao do problema', 'Solucao: apresentacao do produto/servico', 'Sobre: prova social e confianca', 'Contato: CTA de conversao'] }
        ]
    },
    'header.elementos': {
        suggestions: ['Logo', 'Menu principal', 'Busca', 'Carrinho', 'Login', 'Idiomas', 'CTA'],
        templates: [
            { label: 'Header E-commerce', items: ['Logo no canto esquerdo', 'Menu de categorias', 'Campo de busca centralizado', 'Icones: usuario, favoritos, carrinho', 'Banner promocional no topo'] },
            { label: 'Header Institucional', items: ['Logo no canto esquerdo', 'Menu horizontal com dropdown', 'Botao de CTA destacado', 'Redes sociais', 'Informacoes de contato'] }
        ]
    },
    'header.menu_itens': {
        suggestions: ['Inicio', 'Sobre', 'Servicos', 'Produtos', 'Blog', 'Contato', 'Orcamento'],
        templates: [
            { label: 'Menu Servicos', items: ['Inicio', 'Servicos (dropdown)', 'Portfolio', 'Sobre', 'Blog', 'Contato'] }
        ]
    },
    'header.breadcrumbs': {
        suggestions: ['Home > Categoria > Produto', 'Sempre visivel', 'Com schema markup', 'Links clicaveis'],
        templates: [
            { label: 'Regras Breadcrumb', items: ['Exibir em todas as paginas exceto Home', 'Usar separador > ou /', 'Ultimo item nao clicavel', 'Implementar schema.org BreadcrumbList'] }
        ]
    },
    'hero.conteudo': {
        suggestions: ['Titulo principal', 'Subtitulo', 'CTA primario', 'Imagem destaque', 'Video background'],
        templates: [
            { label: 'Hero Completo', items: ['Titulo impactante com palavra-chave', 'Subtitulo explicativo (1 linha)', 'Botao de CTA primario', 'Botao de CTA secundario', 'Imagem ou video de alta qualidade'] }
        ]
    },
    'hero.cta_hero': {
        suggestions: ['Saiba Mais', 'Comece Agora', 'Fale Conosco', 'Ver Produtos', 'Solicitar Orcamento'],
        templates: [
            { label: 'CTAs Efetivos', items: ['CTA primario: acao desejada (ex: Comece Gratis)', 'CTA secundario: baixo comprometimento (ex: Saiba Mais)', 'Usar verbos de acao'] }
        ]
    },
    'hero.banners': {
        suggestions: ['Banner promocional', 'Banner sazonal', 'Anuncio produto', 'Novidades'],
        templates: [
            { label: 'Sistema de Banners', items: ['Banner rotativo na home (3-5 slides)', 'Banners laterais em categoria', 'Banner fixo de promocao', 'Banner de newsletter'] }
        ]
    },
    'paginas.home': {
        suggestions: ['Hero', 'Beneficios', 'Produtos', 'Depoimentos', 'CTA final', 'FAQ', 'Newsletter'],
        templates: [
            { label: 'Home Institucional', items: ['Hero com proposta de valor', 'Secao de beneficios (3 colunas)', 'Servicos principais', 'Depoimentos de clientes', 'CTA de contato'] },
            { label: 'Home E-commerce', items: ['Hero com ofertas', 'Categorias principais', 'Produtos em destaque', 'Banner promocional', 'Newsletter'] }
        ]
    },
    'paginas.sobre': {
        suggestions: ['Historia', 'Missao e valores', 'Equipe', 'Diferenciais', 'Certificacoes'],
        templates: [
            { label: 'Sobre Completo', items: ['Historia da empresa', 'Missao, visao e valores', 'Equipe com fotos', 'Numeros e conquistas', 'Certificacoes e premios'] }
        ]
    },
    'paginas.contato': {
        suggestions: ['Formulario', 'Telefone', 'Email', 'Endereco', 'Mapa', 'Redes sociais', 'Horario'],
        templates: [
            { label: 'Contato Completo', items: ['Formulario de contato com validacao', 'Telefone e WhatsApp', 'Email de contato', 'Endereco fisico com mapa', 'Horario de atendimento'] }
        ]
    },
    'paginas.servicos': {
        suggestions: ['Grid de servicos', 'Descricao detalhada', 'Precos', 'Portfolio', 'CTA orcamento'],
        templates: [
            { label: 'Pagina de Servicos', items: ['Lista de servicos oferecidos', 'Descricao de cada servico', 'Beneficios e diferenciais', 'Cases ou portfolio', 'Formulario de orcamento'] }
        ]
    },
    'paginas.blog': {
        suggestions: ['Grid de posts', 'Categorias', 'Busca', 'Posts relacionados', 'Newsletter', 'Sidebar'],
        templates: [
            { label: 'Blog Estruturado', items: ['Grid de posts com thumbnail', 'Sidebar com categorias', 'Campo de busca', 'Posts populares', 'Formulario de newsletter'] }
        ]
    },
    'cores.primaria': {
        suggestions: ['#1E40AF', '#7C3AED', '#059669', '#DC2626', '#F59E0B'],
        templates: [
            { label: 'Cor Primaria', items: ['Definir cor principal da marca', 'Testar contraste WCAG AA', 'Criar variacoes (light, dark)'] }
        ]
    },
    'cores.secundaria': {
        suggestions: ['#6B7280', '#94A3B8', '#E5E7EB', '#F3F4F6', '#FFFFFF'],
        templates: [
            { label: 'Cores Secundarias', items: ['Definir 2-3 cores de apoio', 'Tons de cinza para textos', 'Cores neutras para fundos'] }
        ]
    },
    'cores.destaque': {
        suggestions: ['#F59E0B', '#EF4444', '#10B981', '#3B82F6', '#8B5CF6'],
        templates: [
            { label: 'Cor de CTA', items: ['Escolher cor que contraste com primaria', 'Testar visibilidade em fundos claros e escuros', 'Usar em botoes e links importantes'] }
        ]
    },
    'tipografia.titulos': {
        suggestions: ['Inter', 'Roboto', 'Montserrat', 'Poppins', 'Raleway', 'Open Sans'],
        templates: [
            { label: 'Fonte de Titulos', items: ['Escolher fonte legivel e moderna', 'Definir pesos: 600-700 para titulos', 'Testar em diferentes tamanhos'] }
        ]
    },
    'tipografia.corpo': {
        suggestions: ['Inter', 'Roboto', 'Open Sans', 'Lato', 'Source Sans Pro'],
        templates: [
            { label: 'Fonte de Corpo', items: ['Escolher fonte legivel para textos longos', 'Peso normal: 400, negrito: 600', 'Line-height entre 1.5-1.7'] }
        ]
    },
    'tipografia.hierarquia_visual': {
        suggestions: ['H1: 48px bold', 'H2: 36px semibold', 'H3: 24px medium', 'Body: 16px regular'],
        templates: [
            { label: 'Escala Tipografica', items: ['H1: 2.5-3rem (40-48px) - Titulo principal', 'H2: 2rem (32px) - Secoes', 'H3: 1.5rem (24px) - Subsecoes', 'Body: 1rem (16px) - Texto corrido', 'Small: 0.875rem (14px) - Legendas'] }
        ]
    },
    'componentes.botoes': {
        suggestions: ['Primario', 'Secundario', 'Outline', 'Texto', 'Icon', 'Fantasma'],
        templates: [
            { label: 'Variantes de Botoes', items: ['Primario: fundo solido, cor destaque', 'Secundario: fundo neutro ou outline', 'Texto: sem borda, apenas texto', 'Icone: botao com icone e/ou texto'] }
        ]
    },
    'componentes.cards': {
        suggestions: ['Card produto', 'Card post', 'Card servico', 'Card testemunho', 'Card equipe'],
        templates: [
            { label: 'Card Produto', items: ['Imagem do produto (ratio 1:1)', 'Titulo do produto', 'Preco com destaque', 'Botao de adicionar ao carrinho', 'Badge de desconto/novo'] }
        ]
    },
    'componentes.formularios': {
        suggestions: ['Campo texto', 'Email', 'Textarea', 'Select', 'Checkbox', 'Radio', 'Upload'],
        templates: [
            { label: 'Formulario Contato', items: ['Campo Nome (obrigatorio)', 'Campo Email (obrigatorio com validacao)', 'Campo Telefone', 'Mensagem (textarea)', 'Checkbox de consentimento LGPD'] }
        ]
    },
    'componentes.modais': {
        suggestions: ['Modal confirmacao', 'Modal formulario', 'Modal galeria', 'Modal video', 'Modal alerta'],
        templates: [
            { label: 'Modal Padrao', items: ['Overlay escuro (80% opacidade)', 'Container centralizado com padding', 'Botao de fechar (X)', 'Titulo do modal', 'Conteudo e acoes'] }
        ]
    },
    'componentes.alertas': {
        suggestions: ['Sucesso', 'Erro', 'Aviso', 'Info', 'Toast'],
        templates: [
            { label: 'Tipos de Alerta', items: ['Sucesso: verde com icone check', 'Erro: vermelho com icone X', 'Aviso: amarelo com icone alerta', 'Info: azul com icone i'] }
        ]
    },
    'layout.grid': {
        suggestions: ['12 colunas', '16px gutter', 'Container 1200px', 'Grid responsivo'],
        templates: [
            { label: 'Sistema Grid', items: ['Grid de 12 colunas', 'Gutter de 16-24px', 'Container max-width 1200px', 'Breakpoints mobile/tablet/desktop'] }
        ]
    },
    'layout.containers': {
        suggestions: ['Container fluido', 'Container fixo', 'Container secao', 'Container card'],
        templates: [
            { label: 'Containers', items: ['Container principal: max-width 1200px, padding lateral 16px', 'Container de secao: padding vertical 60-80px', 'Container fluido: width 100% com padding'] }
        ]
    },
    'performance.imagens': {
        suggestions: ['WebP', 'Lazy loading', 'Responsive images', 'Compressao 80%', 'CDN'],
        templates: [
            { label: 'Otimizacao de Imagens', items: ['Usar formato WebP com fallback', 'Implementar lazy loading', 'Definir width/height para evitar CLS', 'Comprimir com qualidade 80-85%', 'Usar CDN para imagens'] }
        ]
    },
    'performance.carregamento': {
        suggestions: ['Critical CSS', 'Defer scripts', 'Code splitting', 'Preload fonts', 'Minificacao'],
        templates: [
            { label: 'Estrategia de Carregamento', items: ['Inline critical CSS', 'Defer ou async em scripts nao criticos', 'Lazy load de componentes', 'Preload de fontes e recursos criticos', 'Minificar CSS e JS'] }
        ]
    },
    'performance.cache': {
        suggestions: ['Browser cache', 'CDN cache', 'Service worker', 'Cache-Control headers'],
        templates: [
            { label: 'Politica de Cache', items: ['Cache de imagens: 30 dias', 'Cache de CSS/JS: 7 dias com versionamento', 'HTML: no-cache', 'Usar CDN para assets estaticos'] }
        ]
    },
    'acessibilidade.alt_texts': {
        suggestions: ['Descricao objetiva', 'Sem "imagem de"', 'Contexto relevante', 'Imagens decorativas vazias'],
        templates: [
            { label: 'Padroes Alt Text', items: ['Descrever conteudo da imagem objetivamente', 'Nao usar "imagem de" ou "foto de"', 'Imagens decorativas: alt vazio', 'Maximo 125 caracteres'] }
        ]
    },
    'acessibilidade.contraste': {
        suggestions: ['WCAG AA: 4.5:1', 'Textos grandes: 3:1', 'Testar com ferramentas', 'Modo escuro'],
        templates: [
            { label: 'Regras de Contraste', items: ['Texto normal: minimo 4.5:1', 'Texto grande (18px+): minimo 3:1', 'Testar com ferramentas WCAG', 'Garantir legibilidade em modo escuro'] }
        ]
    },
    'acessibilidade.teclado': {
        suggestions: ['Tab para navegar', 'Enter para ativar', 'Esc para fechar', 'Focus visivel', 'Skip links'],
        templates: [
            { label: 'Navegacao por Teclado', items: ['Navegacao com Tab em ordem logica', 'Enter/Space para ativar botoes', 'Esc para fechar modais', 'Focus visivel em todos elementos interativos', 'Skip link para conteudo principal'] }
        ]
    }
},

seguranca: {
    'https.configuracao': {
        suggestions: ['Redirecionar HTTP para HTTPS', 'HSTS habilitado', 'Certificado valido', 'Renovacao automatica'],
        templates: [
            { label: 'Checklist SSL', items: ['Instalar certificado SSL valido', 'Redirecionar todo trafego HTTP para HTTPS', 'Habilitar HSTS', 'Configurar renovacao automatica', 'Testar em SSL Labs'] }
        ]
    },
    'https.renovacao': {
        suggestions: ['Certbot com cronjob', 'Renovacao 30 dias antes', 'Notificacao de expiracao', 'Backup do certificado'],
        templates: [
            { label: 'Processo de Renovacao', items: ['Configurar renovacao automatica com Certbot', 'Agendar verificacao mensal', 'Receber alertas 30 dias antes da expiracao', 'Manter backup dos certificados'] }
        ]
    },
    'headers.csp': {
        suggestions: ["default-src 'self'", "script-src 'self'", "style-src 'self' 'unsafe-inline'", 'img-src *'],
        templates: [
            { label: 'CSP Basico', items: ["default-src 'self'", "script-src 'self' https://cdn.exemplo.com", "style-src 'self' 'unsafe-inline'", "img-src 'self' data: https:", "font-src 'self' https://fonts.gstatic.com"] }
        ]
    },
    'headers.hsts': {
        suggestions: ['max-age=31536000', 'includeSubDomains', 'preload'],
        templates: [
            { label: 'HSTS Recomendado', items: ['max-age=31536000 (1 ano)', 'includeSubDomains', 'preload (apos teste)'] }
        ]
    },
    'headers.outros': {
        suggestions: ['X-Frame-Options: DENY', 'X-Content-Type-Options: nosniff', 'Referrer-Policy', 'Permissions-Policy'],
        templates: [
            { label: 'Headers Essenciais', items: ['X-Frame-Options: SAMEORIGIN', 'X-Content-Type-Options: nosniff', 'X-XSS-Protection: 1; mode=block', 'Referrer-Policy: strict-origin-when-cross-origin', 'Permissions-Policy: geolocation=(), microphone=()'] }
        ]
    },
    'headers.cors': {
        suggestions: ['Access-Control-Allow-Origin', 'Access-Control-Allow-Methods', 'Whitelist de dominios'],
        templates: [
            { label: 'Configuracao CORS', items: ['Definir Access-Control-Allow-Origin especifico', 'Listar metodos permitidos (GET, POST)', 'Especificar headers permitidos', 'Definir max-age para preflight'] }
        ]
    },
    'auth.senhas': {
        suggestions: ['Minimo 8 caracteres', 'Letras e numeros', 'Hash bcrypt', 'Senha forte obrigatoria'],
        templates: [
            { label: 'Politica de Senhas', items: ['Minimo 8 caracteres (recomendado 12+)', 'Exigir maiuscula, minuscula e numero', 'Pelo menos 1 caractere especial', 'Hash com bcrypt ou Argon2', 'Impedir senhas comuns'] }
        ]
    },
    'auth.sessoes': {
        suggestions: ['Timeout de 30 minutos', 'Tokens seguros', 'Logout em todos dispositivos', 'Regenerar session ID'],
        templates: [
            { label: 'Gerenciamento de Sessoes', items: ['Timeout de inatividade: 30 minutos', 'Regenerar session ID apos login', 'Cookies com flags Secure e HttpOnly', 'Implementar logout em todos dispositivos'] }
        ]
    },
    'injecao.sql': {
        suggestions: ['Prepared statements', 'ORM', 'Validacao de inputs', 'Escape de caracteres'],
        templates: [
            { label: 'Protecao SQL Injection', items: ['Usar prepared statements ou ORM', 'Validar e sanitizar todos inputs', 'Escapar caracteres especiais', 'Principio do menor privilegio no banco'] }
        ]
    },
    'injecao.xss': {
        suggestions: ['Sanitizar inputs', 'Escapar outputs', 'Content Security Policy', 'httpOnly em cookies'],
        templates: [
            { label: 'Protecao XSS', items: ['Sanitizar todos inputs de usuario', 'Escapar output em HTML/JS/CSS', 'Implementar CSP rigoroso', 'Usar httpOnly e Secure em cookies'] }
        ]
    },
    'injecao.csrf': {
        suggestions: ['CSRF tokens', 'SameSite cookies', 'Verificar origin', 'Double submit'],
        templates: [
            { label: 'Protecao CSRF', items: ['Implementar CSRF tokens em formularios', 'Cookies com SameSite=Strict ou Lax', 'Validar header Origin/Referer', 'Reautenticacao em acoes sensiveis'] }
        ]
    },
    'injecao.outros_ataques': {
        suggestions: ['XXE', 'SSRF', 'Path Traversal', 'Command Injection', 'LDAP Injection'],
        templates: [
            { label: 'Outros Vetores', items: ['Proteger contra XXE em XML', 'Validar URLs em SSRF', 'Sanitizar paths em upload', 'Escapar comandos de sistema'] }
        ]
    },
    'lgpd.consentimento': {
        suggestions: ['Banner de cookies', 'Opt-in explicito', 'Gerenciar preferencias', 'Aceite documentado'],
        templates: [
            { label: 'Sistema de Consentimento', items: ['Banner de cookies com opcoes claras', 'Opt-in explicito (nao pre-marcado)', 'Painel de gerenciamento de preferencias', 'Registrar data/hora do consentimento', 'Permitir revogacao facil'] }
        ]
    },
    'lgpd.politica': {
        suggestions: ['Dados coletados', 'Finalidade', 'Base legal', 'Compartilhamento', 'Retencao'],
        templates: [
            { label: 'Politica de Privacidade', items: ['Listar dados coletados e finalidade', 'Explicar base legal (consentimento, contrato)', 'Informar compartilhamento com terceiros', 'Definir periodo de retencao', 'Contato do DPO ou responsavel'] }
        ]
    },
    'lgpd.direitos': {
        suggestions: ['Acesso aos dados', 'Correcao', 'Exclusao', 'Portabilidade', 'Revogacao'],
        templates: [
            { label: 'Direitos do Titular', items: ['Confirmacao de tratamento de dados', 'Acesso aos dados pessoais', 'Correcao de dados incompletos', 'Anonimizacao ou exclusao', 'Portabilidade e revogacao de consentimento'] }
        ]
    },
    'lgpd.dpo': {
        suggestions: ['Nomear DPO', 'Canal de contato', 'Treinamento equipe', 'Registro de atividades'],
        templates: [
            { label: 'DPO e Processos', items: ['Nomear DPO ou responsavel pela privacidade', 'Publicar canal de contato (email, formulario)', 'Treinar equipe sobre LGPD', 'Manter registro de atividades de tratamento', 'Processo de resposta a incidentes'] }
        ]
    },
    'backup.estrategia': {
        suggestions: ['Backup diario', 'Backup semanal completo', 'Retencao 30 dias', 'Regra 3-2-1'],
        templates: [
            { label: 'Estrategia 3-2-1', items: ['3 copias dos dados', '2 midias diferentes', '1 copia offsite', 'Backup automatico diario', 'Retencao de 30 dias'] }
        ]
    },
    'backup.locais': {
        suggestions: ['Servidor local', 'Cloud storage', 'Disco externo', 'S3', 'Google Drive'],
        templates: [
            { label: 'Locais de Backup', items: ['Backup primario em servidor local', 'Backup secundario em cloud (S3, Google Cloud)', 'Backup offline em disco externo'] }
        ]
    },
    'backup.restauracao': {
        suggestions: ['Documentar processo', 'Testar mensalmente', 'RTO definido', 'Checklist de verificacao'],
        templates: [
            { label: 'Processo de Restauracao', items: ['Documentar passo a passo da restauracao', 'Definir RTO (Recovery Time Objective)', 'Testar restauracao mensalmente', 'Validar integridade apos restauracao'] }
        ]
    },
    'backup.testes': {
        suggestions: ['Teste mensal', 'Restauracao parcial', 'Validar integridade', 'Documentar resultados'],
        templates: [
            { label: 'Rotina de Testes', items: ['Realizar teste de restauracao mensalmente', 'Testar backup parcial e completo', 'Validar integridade dos arquivos', 'Documentar tempo de restauracao'] }
        ]
    },
    'monitoramento.ferramentas': {
        suggestions: ['Google Analytics', 'Sentry', 'New Relic', 'Datadog', 'Prometheus', 'Grafana'],
        templates: [
            { label: 'Stack de Monitoramento', items: ['Monitoramento de uptime (UptimeRobot)', 'APM para performance (New Relic, Datadog)', 'Error tracking (Sentry)', 'Logs centralizados (ELK, Splunk)'] }
        ]
    },
    'monitoramento.logs': {
        suggestions: ['Logs de acesso', 'Logs de erro', 'Logs de autenticacao', 'Retencao 90 dias', 'Rotacao diaria'],
        templates: [
            { label: 'Politica de Logs', items: ['Registrar acessos, erros e eventos de seguranca', 'Rotacao diaria de logs', 'Retencao de 90 dias', 'Centralizacao em sistema de log management', 'Proteger logs contra alteracao'] }
        ]
    },
    'atualizacoes.cms': {
        suggestions: ['WordPress 6.x', 'Verificacao semanal', 'Atualizacao em staging', 'Backup antes'],
        templates: [
            { label: 'Gestao de Atualizacoes', items: ['Verificar atualizacoes semanalmente', 'Testar em ambiente de staging primeiro', 'Fazer backup completo antes de atualizar', 'Aplicar patches de seguranca imediatamente'] }
        ]
    },
    'atualizacoes.dependencias': {
        suggestions: ['npm audit', 'Dependabot', 'Snyk', 'Atualizacao mensal', 'Lock files'],
        templates: [
            { label: 'Gestao de Dependencias', items: ['Usar ferramentas de auditoria (npm audit, Snyk)', 'Habilitar Dependabot ou Renovate', 'Revisar e atualizar dependencias mensalmente', 'Manter lock files versionados'] }
        ]
    },
    'atualizacoes.servidor': {
        suggestions: ['Ubuntu LTS', 'Patches automaticos', 'Kernel atualizado', 'PHP 8.x'],
        templates: [
            { label: 'Atualizacoes de Servidor', items: ['Habilitar atualizacoes automaticas de seguranca', 'Aplicar patches de kernel mensalmente', 'Manter SO em versao LTS suportada', 'Atualizar runtime (PHP, Node) regularmente'] }
        ]
    },
    'ddos.rate_limiting': {
        suggestions: ['100 req/min por IP', 'Limitar login', 'Throttling de API', 'Captcha apos limite'],
        templates: [
            { label: 'Regras Rate Limiting', items: ['Limite global: 100 requisicoes/minuto por IP', 'Login: maximo 5 tentativas/hora', 'API: 60 requisicoes/minuto por token', 'Implementar backoff exponencial'] }
        ]
    },
    'ddos.waf': {
        suggestions: ['Cloudflare WAF', 'AWS WAF', 'ModSecurity', 'Regras OWASP'],
        templates: [
            { label: 'Configuracao WAF', items: ['Implementar WAF (Cloudflare, AWS)', 'Habilitar regras OWASP Core Rule Set', 'Bloquear paises irrelevantes', 'Monitorar e ajustar falsos positivos'] }
        ]
    },
    'servidor.firewall': {
        suggestions: ['UFW habilitado', 'Portas 80/443 abertas', 'SSH apenas IP whitelisted', 'Bloqueio de paises'],
        templates: [
            { label: 'Regras de Firewall', items: ['Habilitar firewall (ufw, iptables)', 'Permitir apenas portas necessarias (80, 443, 22)', 'Restringir SSH a IPs especificos', 'Implementar fail2ban'] }
        ]
    },
    'servidor.acesso': {
        suggestions: ['SSH com chave', 'Desabilitar root login', 'Sudo para admin', 'Auditoria de acessos'],
        templates: [
            { label: 'Controle de Acesso', items: ['Autenticacao SSH apenas com chave publica', 'Desabilitar login direto como root', 'Usar sudo para tarefas administrativas', 'Auditar logs de acesso regularmente'] }
        ]
    },
    'servidor.permissoes': {
        suggestions: ['Arquivos: 644', 'Diretorios: 755', 'Config: 600', 'Dono www-data'],
        templates: [
            { label: 'Permissoes Recomendadas', items: ['Arquivos: 644 (rw-r--r--)', 'Diretorios: 755 (rwxr-xr-x)', 'Arquivos de configuracao: 600', 'Uploads: 644 com validacao'] }
        ]
    },
    'servidor.hardening': {
        suggestions: ['Desabilitar servicos nao usados', 'Remover software desnecessario', 'Kernel hardening', 'SELinux'],
        templates: [
            { label: 'Hardening do Servidor', items: ['Desabilitar servicos e portas nao utilizados', 'Remover pacotes desnecessarios', 'Configurar parametros de kernel (sysctl)', 'Ocultar versoes de software em headers'] }
        ]
    }
},

shopee: {
    'loja.nome': {
        suggestions: ['MinhaLoja Oficial', 'Loja Premium', 'Store Brasil'],
        templates: [
            { label: 'Dicas de Nome', items: ['Nome curto e memoravel', 'Evitar numeros e caracteres especiais', 'Incluir palavra-chave do nicho se possivel'] }
        ]
    },
    'loja.descricao': {
        suggestions: ['Produtos de qualidade', 'Entrega rapida', 'Atendimento diferenciado', 'Precos competitivos'],
        templates: [
            { label: 'Descricao Atrativa', items: ['Apresentar o diferencial da loja', 'Mencionar categorias principais', 'Destacar beneficios (frete, garantia)', 'Informar horario de atendimento'] }
        ]
    },
    'loja.politicas': {
        suggestions: ['Politica de troca', 'Politica de privacidade', 'Termos de uso', 'Garantia'],
        templates: [
            { label: 'Politicas Essenciais', items: ['Politica de trocas e devolucoes', 'Politica de privacidade (LGPD)', 'Garantia dos produtos', 'Prazo de envio e entrega', 'Politica de cancelamento'] }
        ]
    },
    'loja.categorias': {
        suggestions: ['Eletronicos', 'Moda', 'Casa e Decoracao', 'Beleza', 'Esportes', 'Livros'],
        templates: [
            { label: 'Organizacao de Categorias', items: ['Definir 3-5 categorias principais', 'Criar subcategorias especificas', 'Usar nomes claros e diretos'] }
        ]
    },
    'produtos.template_titulo': {
        suggestions: ['Marca', 'Modelo', 'Caracteristica principal', 'Cor/Tamanho', 'Palavra-chave'],
        templates: [
            { label: 'Estrutura de Titulo', items: ['Palavra-chave principal no inicio', 'Marca e modelo', 'Caracteristica diferencial', 'Especificacao (cor, tamanho)', 'Limite de 60-80 caracteres'] }
        ]
    },
    'produtos.template_descricao': {
        suggestions: ['Introducao', 'Beneficios', 'Especificacoes', 'Modo de usar', 'Garantia'],
        templates: [
            { label: 'Descricao Completa', items: ['Introducao: problema que resolve', 'Beneficios principais (bullet points)', 'Especificacoes tecnicas', 'Conteudo da embalagem', 'Informacoes de garantia e troca'] }
        ]
    },
    'produtos.variantes': {
        suggestions: ['Cor', 'Tamanho', 'Voltagem', 'Modelo', 'Capacidade'],
        templates: [
            { label: 'Gestao de Variantes', items: ['Definir atributos relevantes (cor, tamanho)', 'Criar SKU unico por variante', 'Manter estoque por variante', 'Fotos especificas quando aplicavel'] }
        ]
    },
    'fotos.especificacoes': {
        suggestions: ['1200x1200px', 'Fundo branco', 'Formato JPG/PNG', 'Maximo 2MB'],
        templates: [
            { label: 'Specs de Imagem', items: ['Tamanho: minimo 800x800px, ideal 1200x1200px', 'Formato: JPG ou PNG', 'Fundo branco ou neutro', 'Peso maximo 2MB por imagem', 'Minimo 5 fotos por produto'] }
        ]
    },
    'fotos.estilo': {
        suggestions: ['Foto principal fundo branco', 'Foto em uso', 'Detalhes', 'Dimensoes', 'Embalagem'],
        templates: [
            { label: 'Checklist de Fotos', items: ['Foto 1: produto em fundo branco', 'Foto 2-3: angulos diferentes', 'Foto 4: produto em uso/contexto', 'Foto 5: detalhes importantes', 'Foto 6: dimensoes ou comparacao'] }
        ]
    },
    'fotos.videos': {
        suggestions: ['Video demonstracao', 'Unboxing', 'Comparacao', 'Maximo 60 segundos'],
        templates: [
            { label: 'Video do Produto', items: ['Duracao: 15-60 segundos', 'Mostrar produto em uso', 'Destacar diferenciais', 'Incluir texto/legenda', 'Formato vertical para mobile'] }
        ]
    },
    'fotos.edicao': {
        suggestions: ['Canva', 'Photoshop', 'Lightroom', 'Remove.bg', 'PicsArt'],
        templates: [
            { label: 'Workflow de Edicao', items: ['Remover fundo (Remove.bg)', 'Ajustar brilho e contraste', 'Aplicar template de marca', 'Exportar em alta qualidade'] }
        ]
    },
    'seo.palavras_chave': {
        suggestions: ['Produto + marca', 'Produto + caracteristica', 'Long tail', 'Produto + uso'],
        templates: [
            { label: 'Pesquisa de Keywords', items: ['Identificar palavra-chave principal do produto', 'Listar variacoes e sinonimos', 'Incluir termos long tail', 'Analisar keywords dos concorrentes'] }
        ]
    },
    'seo.titulo_otimizado': {
        suggestions: ['Palavra-chave no inicio', 'Maximo 80 caracteres', 'Incluir especificacao', 'Evitar caracteres especiais'],
        templates: [
            { label: 'Otimizacao de Titulo', items: ['Palavra-chave nos primeiros 50 caracteres', 'Incluir marca reconhecida', 'Adicionar diferencial competitivo', 'Maximo 80 caracteres'] }
        ]
    },
    'seo.tags': {
        suggestions: ['Categoria', 'Marca', 'Material', 'Cor', 'Uso', 'Publico-alvo'],
        templates: [
            { label: 'Estrategia de Tags', items: ['Usar todas as tags relevantes permitidas', 'Incluir sinonimos e variacoes', 'Tags de categoria e subcategoria', 'Tags de caracteristicas e uso'] }
        ]
    },
    'seo.busca': {
        suggestions: ['Atualizar titulo', 'Testar busca', 'Analisar concorrentes', 'Ajustar por performance'],
        templates: [
            { label: 'Otimizacao de Busca', items: ['Monitorar posicao nas buscas relevantes', 'Testar busca como comprador', 'Analisar titulos dos top 3 concorrentes', 'Ajustar keywords com base em vendas'] }
        ]
    },
    'logistica.embalagem': {
        suggestions: ['Caixa de papelao', 'Plastico bolha', 'Fita adesiva', 'Etiqueta', 'Papel de seda'],
        templates: [
            { label: 'Checklist Embalagem', items: ['Embalar produto em plastico bolha ou papel', 'Usar caixa de tamanho adequado', 'Preencher espacos vazios', 'Vedar com fita adesiva resistente', 'Incluir nota fiscal ou cupom'] }
        ]
    },
    'logistica.frete': {
        suggestions: ['Frete gratis acima de X', 'Frete fixo', 'Frete por peso', 'Frete calculado'],
        templates: [
            { label: 'Estrategia de Frete', items: ['Frete gratis para pedidos acima de R$ X', 'Calcular frete por peso e regiao', 'Considerar subsidiar parte do frete', 'Usar Shopee Envios quando vantajoso'] }
        ]
    },
    'atendimento.trocas': {
        suggestions: ['Analisar solicitacao', 'Aprovar troca', 'Enviar etiqueta retorno', 'Receber produto', 'Enviar novo'],
        templates: [
            { label: 'Processo de Troca', items: ['Receber solicitacao e analisar motivo', 'Aprovar troca se dentro da politica', 'Orientar cliente sobre retorno', 'Receber produto e inspecionar', 'Enviar novo ou estornar valor'] }
        ]
    },
    'atendimento.pos_venda': {
        suggestions: ['Pedir avaliacao', 'Enviar cupom desconto', 'Newsletter', 'Pesquisa satisfacao'],
        templates: [
            { label: 'Acoes Pos-Venda', items: ['Enviar mensagem de agradecimento', 'Solicitar avaliacao educadamente', 'Oferecer cupom para proxima compra', 'Responder avaliacoes (positivas e negativas)'] }
        ]
    },
    'anuncios.segmentacao': {
        suggestions: ['Segmentar por genero', 'Segmentar por idade', 'Segmentar por interesse', 'Remarketing'],
        templates: [
            { label: 'Regras de Segmentacao', items: ['Definir publico-alvo (idade, genero, localizacao)', 'Segmentar por interesse relacionado', 'Criar audiencia de remarketing', 'Ajustar com base em conversao'] }
        ]
    },
    'anuncios.otimizacao': {
        suggestions: ['Pausar keywords ruins', 'Aumentar lance em top keywords', 'Testar novos anuncios', 'Ajustar orcamento'],
        templates: [
            { label: 'Checklist Otimizacao', items: ['Pausar keywords com baixa conversao', 'Aumentar lance em keywords com ROI positivo', 'Testar novos criativos e textos', 'Ajustar orcamento por desempenho', 'Revisar semanalmente'] }
        ]
    },
    'metricas.kpis': {
        suggestions: ['Taxa de conversao', 'Ticket medio', 'ROI', 'CTR', 'Taxa de rejeicao'],
        templates: [
            { label: 'KPIs Principais', items: ['Numero de vendas', 'Receita total', 'Taxa de conversao', 'Ticket medio', 'Custo de aquisicao (CAC)', 'Avaliacao da loja'] }
        ]
    },
    'metricas.relatorios': {
        suggestions: ['Relatorio diario', 'Relatorio semanal', 'Relatorio mensal', 'Dashboard'],
        templates: [
            { label: 'Rotina de Relatorios', items: ['Diario: vendas e estoque', 'Semanal: performance de anuncios', 'Mensal: analise completa e tendencias', 'Criar dashboard visual'] }
        ]
    },
    'metricas.acoes': {
        suggestions: ['Otimizar baixa conversao', 'Aumentar estoque bestseller', 'Criar promocao', 'Melhorar fotos'],
        templates: [
            { label: 'Plano de Acao', items: ['Identificar produtos com alta visualizacao e baixa conversao', 'Melhorar fotos e descricao desses produtos', 'Criar promocao para produtos parados', 'Reabastecer bestsellers'] }
        ]
    },
    'crescimento.escala': {
        suggestions: ['Expandir catalogo', 'Novos nichos', 'Aumentar orcamento ads', 'Contratar ajuda'],
        templates: [
            { label: 'Estrategia de Escala', items: ['Expandir catalogo com produtos complementares', 'Testar novos nichos relacionados', 'Aumentar orcamento de anuncios gradualmente', 'Automatizar processos repetitivos'] }
        ]
    },
    'crescimento.parcerias': {
        suggestions: ['Micro influenciadores', 'Afiliados', 'Shopee Lives', 'Colaboracoes'],
        templates: [
            { label: 'Parcerias Estrategicas', items: ['Identificar micro influenciadores do nicho', 'Propor parceria com envio de produto', 'Participar de Shopee Lives', 'Criar programa de afiliados'] }
        ]
    },
    'crescimento.cross_sell': {
        suggestions: ['Combos', 'Produtos relacionados', 'Desconto progressivo', 'Leve 2 pague 1'],
        templates: [
            { label: 'Tecnicas Cross-sell', items: ['Criar combos de produtos complementares', 'Sugerir produtos relacionados na descricao', 'Oferecer desconto progressivo', 'Usar cupons para segunda compra'] }
        ]
    },
    'crescimento.fidelizacao': {
        suggestions: ['Programa de pontos', 'Cupons exclusivos', 'Grupo VIP', 'Atendimento personalizado'],
        templates: [
            { label: 'Acoes de Fidelizacao', items: ['Criar lista de clientes recorrentes', 'Enviar cupons exclusivos para clientes fieis', 'Grupo VIP no WhatsApp ou Telegram', 'Atendimento prioritario', 'Brindes surpresa'] }
        ]
    }
}
};
