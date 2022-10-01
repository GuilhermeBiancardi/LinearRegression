<?php

class LinearRegression {
    
    private $data = Array();
    private $coeficient0 = 0;
    private $coeficient1 = 0;
    private $errors = Array();

    /**
     * Linear Function
     *
     * @param float $coeficient0
     * @param float $x0
     * @param float $coeficient1
     * @param float $x1
     * @return float
     */
    private function linearFunction (float $coeficient0, float $x0, float $coeficient1, float $x1) : float {
        return $coeficient0 * $x0 + $coeficient1 * $x1;
    }
    
    /**
     * Square Error
     *
     * @param float $coeficient0
     * @param float $coeficient1
     * @param array $data
     * @return float
     */
    private function squaredError(float $coeficient0, float $coeficient1, array $data): float {
        return array_sum (
            array_map ( function ($point) use ($coeficient0, $coeficient1) {
                return ($point[2] - $this->linearFunction($coeficient0, $point[0], $coeficient1, $point[1])) ** 2;
            }, $data)
        ) / count($data);
    }
    
    /**
     * Gradient Descent
     *
     * @param integer $m
     * @param float $coeficient0
     * @param float $coeficient1
     * @param array $data
     * @return float
     */
    private function descent(int $m, float $coeficient0, float $coeficient1, array $data): float {
        return (-2 / count($data)) * array_sum (
            array_map (
                function ($point) use ($coeficient0, $coeficient1, $m) {
                    return ($point[2] - $this->linearFunction($coeficient0, $point[0], $coeficient1, $point[1])) * $point[$m];
                }, $data
            )
        );
    }
    
    /**
     * Adapt Coeficient 0
     *
     * @param float $coeficient0
     * @param float $coeficient1
     * @param array $data
     * @param float $learningRate
     * @return float
     */
    private function adaptC0(float $coeficient0, float $coeficient1, array $data, float $learningRate): float {
        return $coeficient0 - $learningRate * $this->descent(0, $coeficient0, $coeficient1, $data);
    }
    
    /**
     * Adapt Coeficient 1
     *
     * @param float $coeficient0
     * @param float $coeficient1
     * @param array $data
     * @param float $learningRate
     * @return float
     */
    private function adaptC1(float $coeficient0, float $coeficient1, array $data, float $learningRate): float {
        return $coeficient1 - $learningRate * $this->descent(1, $coeficient0, $coeficient1, $data);
    }

    /**
     * Import data to class
     *
     * @param array $x
     * @param array $y
     * @param float $c0
     * @param float $c1
     * @return void
     */
    public function setData(array $x, array $y, float $c0 = 0, float $c1 = 0): void {
        foreach ($y as $key => $value) {
            $this->data[] = [1, $x[$key]["preco"], $value["preco"]];
            $c0 != 0 ? $this->coeficient0 = $c0 : $this->coeficient0 = $x[$key]["preco"];
            $c1 != 0 ? $this->coeficient1 = $c1 : $this->coeficient1 = $value["preco"];
        }
    }

    /**
     * Get the error of linear result
     *
     * @return array
     */
    public function getError(): array {
        return $this->errors;
    }

    /**
     * Get data
     *
     * @return array
     */
    public function getData(): array {
        return $this->data;
    }

    
    /**
     * Train the data
     *
     * @param float $learningRate
     * @param integer $loop
     * @return array
     */
    public function train(float $learningRate = 0.1, int $loop = 750): array {

        for ($i = 0; $i < $loop; $i++) {

            // Armazeno os erros de cada interação
            $this->errors[] = $this->squaredError($this->coeficient0, $this->coeficient1, $this->data);
        
            // Descubro os novos coeficientes
            $newCoeficient0 = $this->adaptC0($this->coeficient0, $this->coeficient1, $this->data, $learningRate);
            $newCoeficient1 = $this->adaptC1($this->coeficient0, $this->coeficient1, $this->data, $learningRate);
        
            $this->coeficient0 = $newCoeficient0;
            $this->coeficient1 = $newCoeficient1;
        }

        return Array (
            "y" => $this->coeficient1,
            "x" => $this->coeficient0,
            "e" => $this->errors[($i - 1)],
        );

    }

    /**
     * Predict values
     *
     * @param [type] $value
     * @return float
     */
    public function predict($value): float {
        return (($this->coeficient1 * $value) + $this->coeficient0);
    }

}

?>
