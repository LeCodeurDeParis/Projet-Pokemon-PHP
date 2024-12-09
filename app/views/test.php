<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Combat Pokémon</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Ajout de la police Pixelify Sans -->
    <style>
        @font-face {
            font-family: 'Pixelify Sans';
            src: url('/app/assets/fonts/PixelifySans-Regular.ttf') format('truetype');
            font-weight: normal;
            font-style: normal;
        }

        @layer utilities {
            .font-pixelify {
                font-family: 'Pixelify Sans', sans-serif;
            }
        }
    </style>
</head>
<body>
<body class="min-h-screen flex flex-col  font-pixelify">
    <header>
        <div class="h-32 bg-gradient-to-b from-[#B22222] via-[#4B4B4B] to-[#1C1C1C]">
            <img src="/app/assets/Logo-Pokemon.png" alt="Logo Pokémon" class="h-full mx-auto">
        </div>
    </header>
    <main class="flex-grow flex flex-col">

        <div class="flex justify-evenly items-center">
            <div class="flex flex-col items-center">
                <div class="flex items-center justify-center w-32 h-[20%] m-4">
                    <img src="/app/assets/sprites/Sprite_<?= htmlspecialchars($pokemon1->nom) ?>.png" alt="<?= htmlspecialchars($pokemon1->nom) ?>" class="w-32 h-auto">
                </div>
                <!-- Affichage du nom et des points de vie du Pokémon 1 -->
                <p><strong><?= htmlspecialchars($pokemon1->nom) ?> </strong> (<?= htmlspecialchars($pokemon1->pointsDeVie) ?> PV)</p>
            </div>
            <p class="text-[5rem]"> vs </p>
            <div class="flex flex-col items-center">
                <div class="flex items center justify-center w-32 h-[20%] m-4">
                    <img src="/app/assets/sprites/Sprite_<?= htmlspecialchars($pokemon2->nom) ?>.png" alt="<?= htmlspecialchars($pokemon2->nom) ?>" class="w-32 h-auto">
                </div>
                <!-- Affichage du nom et des points de vie du Pokémon 2 -->
                <p><strong><?= htmlspecialchars($pokemon2->nom) ?></strong> (<?= htmlspecialchars($pokemon2->pointsDeVie) ?> PV)</p>
            </div>

        </div>
        <div class="flex flex-col justify-center items-center gap-4">
            <!-- Affichage des messages de combat -->
            <h2>Messages de combat :</h2>
            <ul>
                <?php foreach ($messages as $message): ?>
                    <li><?= htmlspecialchars($message) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    </main>
    <footer>
        <div class="h-32 bg-gradient-to-t from-[#B22222] via-[#4B4B4B] to-[#1C1C1C] flex justify-center items-center text-lg">
            <div class="flex justify-between items-center w-full">
                <!-- Affichage du bouton pour recommencer le combat -->
                <form method="POST" action="/Combat/recommencer">
                    <button type="submit" name="recommencer" class="bg-[url('/app/assets/background/bouton_restart.png')] w-48 h-24 bg-contain bg-left bg-no-repeat text-white py-2 rounded text-start text-xs">Restart</button>
                </form>
                <div class="flex justify-evenly items-center">
                    <form method="POST" action="/Combat/attaquer" class="text-lg">
                        <label for="attaque"></label>
                        <!-- Affichage des attaques du Pokémon 1 -->
                        <?php foreach ($pokemon1->attaques as $index => $attaque): ?>
                            <?php switch ($pokemon1->type) {
                                case 'Feu':
                                    ?>
                                    <button type="submit" name="attaque" value="<?= htmlspecialchars($attaque->getID()) ?>" class="bg-[url('/app/assets/background/bouton_feu.png')] w-64 h-32 bg-contain bg-center bg-no-repeat text-white px-4 py-2 rounded"><?= htmlspecialchars($attaque->getNom()) ?></button>
                                    <?php
                                    break;
                                case 'Eau':
                                    ?>
                                    <button type="submit" name="attaque" value="<?= htmlspecialchars($attaque->getID()) ?>" class="bg-[url('/app/assets/background/bouton_eau.png')] w-64 h-32 bg-contain bg-center bg-no-repeat text-white px-4 py-2 rounded"><?= htmlspecialchars($attaque->getNom()) ?></button>
                                    <?php
                                    break;
                                case 'Plante':
                                    ?>
                                    <button type="submit" name="attaque" value="<?= htmlspecialchars($attaque->getID()) ?>" class="bg-[url('/app/assets/background/bouton_plante.png')] w-64 h-32 bg-contain bg-center bg-no-repeat text-white px-4 py-2 rounded"><?= htmlspecialchars($attaque->getNom()) ?></button>
                                    <?php
                                    break;
                                default:
                                    ?>
                                    <button type="submit" name="attaque" value="<?= htmlspecialchars($attaque->getID()) ?>" class="bg-[url('/app/assets/background/bouton_default.png')] w-64 h-32 bg-contain bg-center bg-no-repeat text-white px-4 py-2 rounded"><?= htmlspecialchars($attaque->getNom()) ?></button>
                                    <?php
                                    break;
                            } ?>
                        <?php endforeach; ?>
                        <input type="hidden" name="pokemonId" value="<?= $pokemon1->id ?>">
                    </form>
                    <!-- Affichage du bouton pour utiliser la capacité spéciale -->
                    <form method="POST" action="/Combat/capaSpeVs">
                        <button type="submit" name="capaSpe" class="bg-[url('/app/assets/background/bouton_spe.png')] w-64 h-32 bg-contain bg-center bg-no-repeat text-white px-4 py-2 rounded">Attaque Spéciale</button>
                    </form>
                </div>
                <!-- Affichage du bouton pour soigner le Pokémon 1 -->
                <form method="POST" action="/Combat/seSoigner">
                    <button type="submit" name="soin" class="bg-[url('/app/assets/background/bouton_soin.png')] w-64 h-24 bg-contain bg-center bg-no-repeat text-white px-4 py-2 rounded text-center">Soigner</button>
                </form>
            </div>
    </footer>
</body>
</html>