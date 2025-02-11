const { execSync } = require("child_process");
const path = require("path");

// Replace this with your plugin's slug
const pluginSlug = "wp-multi-contributors";

try {
	console.log(`Generating .pot file for plugin: ${pluginSlug}...`);
	const command = `
	wp i18n make-pot ../ ../languages*/${pluginSlug}.pot \
	--exclude=wordpress,vendor,dist,tests,src \
	--domain=${pluginSlug}
	`;
	// Execute the command
	execSync(command, { stdio: "inherit", cwd: path.resolve(__dirname) });
	console.log(`.pot file successfully created at ./languages/${pluginSlug}.pot`);
} catch (error) {
	console.error("Error generating .pot file:", error.message);
}
