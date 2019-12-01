<?php

Class Sorteio
{
    private $quantidadeDezenas;
    private $resultado;
    private $totalJogos;
    private $jogos;

    /**
     * Construtor
     * @param int $qtdDezenas - quantidade de dezenas por jogo
     * @param int $totalJogos - total de jogos
     * @return object Instância da classe Sorteio
     */ 
    public function __construct(int $quantidadeDezenas, int $totalJogos)
    {
        $this->setQuantidadeDezenas($quantidadeDezenas);
        $this->setTotalJogos($totalJogos);
    }

    /**
     * Sorteia as dezenas de um jogo sem permitir repetição e também ordena as dezenas
     * @param int $quantidadeDezenas - quantidade de dezenas que serão sorteadas
     * @return array $jogo - array contendo as dezenas sorteadas
     */ 
    private function sorteiaDezenas(int $quantidadeDezenas): array
    {
        $jogo = [];
        while (count($jogo) < $quantidadeDezenas) {
            $dezenaSorteada = rand(1, 60);
            if (!in_array($dezenaSorteada, $jogo)) {
                $jogo[] = $dezenaSorteada;
            }
        }
  
        sort($jogo, SORT_NUMERIC);
        return $jogo;
    }

    /**
     * Sorteia as dezenas de acordo com o atributo $quantidadeDezenas e alimenta o atributo $jogos
     */ 
    public function preencheJogos(): void
    {
        $jogos = [];
        for ($i = 0; $i < $this->getTotalJogos(); $i++) {
            $jogos[] = $this->sorteiaDezenas($this->getQuantidadeDezenas());
        }
        $this->setJogos($jogos);
    }

    /**
     * Sorteia seis dezenas e alimenta o atributo $resultado
     */ 
    public function sorteiaResultado(): void
    {
        $resultado = $this->sorteiaDezenas(6);

        $this->setResultado($resultado);
    }

     /**
     * Confere a quantidade de acertos de cada jogo
     * @return array $jogo - array contendo os jogos e a quantidade de acertos de cada um deles
     */ 
    public function confereJogos(): array 
    {
        $jogos = [];
        foreach ($this->getJogos() as $jogo) {
            $quantidadeAcertos = 0;
            foreach ($jogo as $dezena) {
                if (in_array($dezena, $this->getResultado())) {
                    $quantidadeAcertos++;
                } 
            }
            $jogos[] = [
                "dezenas" => $jogo,
                "quantidadeAcertos" => $quantidadeAcertos
            ];
        }
       
        return $jogos;
    }

    /**
     * Define a quantidade de dezenas que cada jogo terá e lança um execeção se o valor for inválido
     * @param int $quantidadeDezenas - quantidade de dezenas por jogo
     */ 
    public function setQuantidadeDezenas(int $quantidadeDezenas): void
    {
        if ($quantidadeDezenas < 6 || $quantidadeDezenas > 10) {
            throw new Exception("Quantidade de dezenas inválida!"); 
        }

        $this->quantidadeDezenas = $quantidadeDezenas;
    }

    /**
     * getter $quantidadeDezenas
     * @return int $quantidadeDezenas - quantidade de dezenas por jogo
     */ 
    public function getQuantidadeDezenas(): int
    {
        return $this->quantidadeDezenas;
    }
    
    /**
     * setter $jogos
     * @param array $jogos - jogos sorteados
     */ 
    public function setJogos(array $jogos): void
    {
        $this->jogos = $jogos;
    }

    /**
     * getter $jogos
     * @return array $jogos - jogos sorteados
     */ 
    public function getJogos(): array
    {
        return $this->jogos;
    }

    /**
     * setter $totalJogos
     * @param int $totalJogos - total de jogos sorteados
     */ 
    public function setTotalJogos(int $totalJogos): void
    {
        $this->totalJogos = $totalJogos;
    }

    /**
     * getter $totalJogos
     * @return int $totalJogos - total de jogos sorteados
     */ 
    public function getTotalJogos(): int
    {
        return $this->totalJogos;
    }

    /**
     * setter $resultado
     * @param array $resultado - resultado do sorteio
     */
    public function setResultado(array $resultado): void
    {
        $this->resultado = $resultado;
    }

    /**
     * getter $resultado
     * @return array $resultado - resultado do sorteio
     */ 
    public function getResultado(): array
    {
        return $this->resultado;
    }
}