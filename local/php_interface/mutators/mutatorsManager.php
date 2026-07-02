<?

namespace Local\PhpInterface\Mutators;

class MutatorsManager
{
    /**
     * Регистрирует модификации из всех файлов в папке mutators
     */
    public static function register()
    {
        // Определяем путь к директории mutators
        $directory = __DIR__;

        // Получаем список всех PHP-файлов, кроме MutatorsManager.php
        $files = glob($directory . '/*.php');

        foreach ($files as $file) {
            if (basename($file) !== 'MutatorsManager.php') {
                require_once $file;
            }
        }
    }
}
