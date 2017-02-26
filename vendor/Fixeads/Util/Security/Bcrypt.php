<?php

namespace Fixeads\Util\Security;

class Bcrypt {
    /**
     * Algoritmo a ser usado pela função "crypt", que no caso representa o "bcrypt/blowfish"
     */
    protected static $_saltPrefix = '2a';

    /**
     * O custo de processamento influencia diretamente nas tentativas de ataque de força bruta.
     * Entretanto quanto maior o custo, mais lento a gerar uma hash, porém melhor.
     * Coloquei um custo de 8, uma vez que o custo é a potência de 2, então 2^8
     *      será cerca de 256 ciclos
     */
    protected static $_defaultCost = 8;

    protected static $_saltLength = 22;

    public static function hash($string, $cost = null) {
        if (empty($cost))
            $cost = self::$_defaultCost;

        $salt = self::generateRandomSalt();
        $hashString = self::__generateHashString((int)$cost, $salt);

        /**
         * Passei 2 valores para a função "crypt":
         * - senha: senha digitada pelo cliente;
         * - $hashString: string composta por 3 partes:
         *     - O método de hashing "2a" que fará com que o bcrypt/blowfish seja usado;
         *     - O custo 8;
         *     - O salt aleatório;
         * O resultado será um hash com 60 caracteres.
         */
        return crypt($string, $hashString);
    }

    /**
     * Gera um salt aleatório.
     * É uma garantia que uma senha nunca será igualmente hasheada duas vezes.
     * A informação é adicionada para que a hash seja mais difícil de decifrar.
     * O salt precisa ser uma string de 22 caracteres que respeite a expressão regular ./0-9A-Za-z.
     */
    public static function generateRandomSalt() {
        $seed = uniqid(mt_rand(), true);
        $salt = base64_encode($seed);
        $salt = str_replace('+', '.', $salt);

        return substr($salt, 0, self::$_saltLength);
    }

    /**
     * Gera a hashstring de acordo com o algoritmo, o custo e o salt.
     * A string será usada na função "crypt"
     */
    private static function __generateHashString($cost, $salt) {
        return sprintf('$%s$%02d$%s$', self::$_saltPrefix, $cost, $salt);
    }
}
